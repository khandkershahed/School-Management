<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fee;
use App\Models\User;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Models\EducationMedium;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Notification;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'students' => User::with('medium')->latest('id')->get(),
        ];

        return view("admin.pages.students.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'mediums' => EducationMedium::get(),
        ];
        return view("admin.pages.students.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'    => 'required',
                'class'   => 'required',
                'medium'  => 'required',
                'section' => 'required',
                'roll'    => 'required|integer',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->messages()->all());
                return redirect()->back()->withInput();
            }

            $code = strtoupper(substr($request->gender, 0, 1)) . $request->year . $request->class . $request->roll;

            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'students/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }


            // create client
            $userSchema = User::create([
                'student_id'       => $code,
                'name'             => $request->name,
                'medium'           => $request->medium,
                // 'medium_id'        => $request->medium_id,
                'class'            => $request->class,
                'section'          => $request->section,
                'student_type'     => $request->student_type,
                'gender'           => $request->gender,
                'group'            => $request->group,
                'year'             => $request->year,
                'roll'             => $request->roll,
                'guardian_name'    => $request->guardian_name,
                'guardian_contact' => $request->guardian_contact,
                'status'           => $request->status,
                'address'          => $request->address,
                'image'            => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
            ]);

            //send welcome notification
            try {
                if ($request->isSendEmail || $request->isSendSMS) {
                    Notification::send($userSchema, new WelcomeNotification($userSchema, [
                        'isSendEmail' => $request->isSendEmail,
                        'isSendSMS' => $request->isSendSMS,
                    ]));
                }
            } catch (Exception $e) {
                //handle email error here if necessary
                throw new Exception($e);
            }
            redirectWithSuccess('Student added successfully');
            return redirect()->route('admin.students.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $student = User::with('invoices', 'waivers', 'paidFees')->where('slug', $slug)->first();
            $fees = Fee::where('medium', $student->medium)
                ->whereJsonContains('class', $student->class)
                ->where('status', 'active')
                ->where('fee_type', '!=' ,'yearly')
                ->get();
            if ($student->student_type == 'old') {
                $package_fees = Fee::where('medium', $student->medium)
                    ->whereJsonContains('class', $student->class)
                    ->whereJsonContains('fee_package', 'session_charge')
                    ->where('status', 'active')
                    ->where('fee_type', 'yearly')->get();
            } else {
                // For new students: Include fees without 'admission_charge' and fees with NULL/empty 'fee_package'
                $package_fees = Fee::where('medium', $student->medium)
                    ->whereJsonContains('class', $student->class)
                    ->whereJsonContains('fee_package', 'admission_charge')
                    ->where('status', 'active')
                    ->where('fee_type', 'yearly')->get();
            }
            $package = $student->student_type == "old" ? 'Session Charge' : 'Admission Charge';
            // Retrieve any waivers for the student
            $waivers = $student->waivers;

            // Create a lookup for the waivers to easily access by fee ID
            $waiversLookup = $waivers->keyBy('fee_id');

            // Get the paid fees for the student (these should not show in the due fees section)
            $paidFees = StudentFee::where('student_id', $student->id)
                ->where('status', 'Paid')
                ->pluck('fee_id'); // Get only the fee IDs of the paid fees

            // Exclude the paid fees from the list of available fees for the due fees section
            $dueFees = $fees->whereNotIn('id', $paidFees);
            $data = [
                'student'       => $student,
                'dueFees'       => $dueFees,
                'waiversLookup' => $waiversLookup,
                'fees'          => $fees,
                'package'       => $package,
                'package_fees'  => $package_fees,
            ];

            return view("admin.pages.students.show", $data);
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = [
                'student' => User::where('slug', $id)->first(),
            ];

            return view("admin.pages.students.edit", $data);
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = User::where('id', $id)->first();
        $this->validate($request, [
            'name'          => 'required|string|max:255',
            // 'phone'         => 'required|string|max:20|min:3',
            // 'email'         => 'nullable|email|max:255|min:3|unique:users,email,' . $client->id,
            'company_name'  => 'nullable|string|max:100|min:2',
            'address'       => 'nullable|string|max:255',
        ]);
        try {
            // upload thumbnail and set the name
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'students/' . $key;
                    $oldFile = $client->$key ?? null;

                    if ($oldFile) {
                        Storage::delete("public/" . $oldFile);
                    }
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }


            // create client
            $client->update([
                'name'             => $request->name,
                'medium'           => $request->medium,
                // 'medium_id'        => $request->medium_id,
                'class'            => $request->class,
                'section'          => $request->section,
                'student_type'     => $request->student_type,
                'gender'           => $request->gender,
                'group'            => $request->group,
                'year'             => $request->year,
                'roll'             => $request->roll,
                'guardian_name'    => $request->guardian_name,
                'guardian_contact' => $request->guardian_contact,
                'status'           => $request->status,
                'address'          => $request->address,
                'image'            => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $client->image,
            ]);

            redirectWithSuccess('Student Data Updated successfully');
            return redirect()->route('admin.students.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = User::where('id', $id)->first();
        $files = [
            'image' => $client->image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $client->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $client->delete();
    }

    public function import(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->all());
            return redirect()->back()->withInput();
        }
        // Get the uploaded file
        $file = $request->file('file');

        try {
            // Import the file using the import class
            Excel::import(new StudentsImport, $file);
            redirectWithSuccess('Student Data Imported successfully');
            return redirect()->route('admin.students.index');
        } catch (\Exception $e) {
            // \Log::error('Error during student data import: ' . $e->getMessage());
            Session::flash('error', $e->getMessage());
            return redirect()->route('admin.students.index');
        }
    }

    public function fetchStudentData(Request $request)
    {
        $studentId = $request->student_id;
        $pattern = '/^[MF]\d+$/';
        if (preg_match($pattern, $studentId)) {
            $student = User::where('student_id', $studentId)->first();
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'No student found with the provided student_id.'
                ], 404);
            }
        } elseif (is_numeric($studentId)) {
            // If only the numeric part is provided, search by the numeric part
            $student = User::where('student_id', 'like', '%' . $studentId)->first();

            // Check if the student exists
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'No student found with the provided numeric part of student_id.'
                ], 404);
            }
        }

        // Check if the student was found
        if ($student) {
            return response()->json([
                'success' => true,
                'student' => $student
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ]);
        }
    }
}
