<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Models\EducationMedium;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
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
            $code = generateCode(User::class, 'SHK');
            
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
                'medium_id'        => $request->medium_id,
                'student_id'       => $code,
                'name'             => $request->name,
                'roll'             => $request->roll,
                'class'            => $request->class,
                'section'          => $request->section,
                'guardian_name'    => $request->guardian_name,
                'guardian_contact' => $request->guardian_contact,
                'address'          => $request->address,
                'status'           => $request->status,
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
            $data = [
                'student' => User::where('slug', $slug)->first(),
            ];

            return view("admin.pages.students.show",$data);
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

            return view("admin.pages.students.edit",$data);
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
                'medium_id'        => $request->medium_id,
                // 'student_id'       => $code,
                'name'             => $request->name,
                'roll'             => $request->roll,
                'class'            => $request->class,
                'section'          => $request->section,
                'guardian_name'    => $request->guardian_name,
                'guardian_contact' => $request->guardian_contact,
                'address'          => $request->address,
                'status'           => $request->status,
                'image'            => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
            ]);

            redirectWithSuccess('Stident Data Updated successfully');
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
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv', // Ensure the file is an Excel file
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Import the file using the import class
        Excel::import(new StudentsImport, $file);

        // Redirect back with success message
        redirectWithSuccess('Stident Data Imported successfully');
            return redirect()->route('admin.students.index');

    }
}
