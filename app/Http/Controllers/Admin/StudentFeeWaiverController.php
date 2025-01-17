<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentFeeWaiver;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StudentFeeWaiverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.studentFeeWaiver.index', [
            'students' => User::with('waivers')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'fee_id' => 'required|array',
                'fee_id.*' => 'exists:fees,id',
                'amount' => 'required|array',
                'amount.*' => 'nullable|numeric|min:0',
                'percentage' => 'nullable|array',
                'percentage.*' => 'nullable|numeric|min:0',
                'student_id' => 'required|exists:users,id',
                'package_amount' => 'nullable|numeric|min:0',
                'package_percentage' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                // If validation fails, flash the error messages and redirect back with input
                Session::flash('error', $validator->messages()->all());
                return redirect()->back()->withInput();
            }

            // Get the student ID and package details
            $studentId = $request->input('student_id');
            $packageAmount = $request->input('package_amount');
            $packagePercentage = $request->input('package_percentage');
            // dd($request->input('fee_id'));
            // Loop through each selected fee ID and their corresponding waiver data
            foreach ($request->input('fee_id') as $feeId) {
                $waivedAmount = $request->input("amount.$feeId");
                $waivedPercentage = $request->input("percentage.$feeId");

                // If the waived amount is provided (non-zero), we create or update the waiver
                if ($waivedAmount > 0 || $waivedPercentage > 0) {
                    StudentFeeWaiver::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'fee_id' => $feeId,
                        ],
                        [
                            'amount' => $waivedAmount,
                            'percentage' => $waivedPercentage,
                            'package_amount' => $packageAmount,
                            'package_percentage' => $packagePercentage,
                            'added_by' => auth()->id(),
                        ]
                    );
                } else {
                    // If waived amount is zero or empty, we remove the waiver
                    StudentFeeWaiver::where('student_id', $studentId)
                        ->where('fee_id', $feeId)
                        ->delete();
                }
            }

            // If all is successful, flash a success message
            Session::flash('success', 'Fee waivers updated successfully.');
        } catch (\Exception $e) {
            // If any exception occurs, catch it and flash an error message
            Session::flash('error',$e->getMessage());

            // Optionally log the exception for debugging
            // \Log::error('Error updating fee waivers: ' . $e->getMessage());
        }

        // Redirect back with the input
        return redirect()->back()->withInput();
    }




    // public function store(Request $request)
    // {
    //         dd($request->all());
    //     $validator = Validator::make($request->all(), [
    //         'fee_id' => 'required|array', // Ensure fee_ids are provided as an array
    //         'fee_id.*' => 'exists:fees,id', // Ensure each fee_id exists in the 'fees' table
    //         'amount' => 'required|array', // Ensure waiver amounts are provided for each fee
    //         'amount.*' => 'numeric|min:0', // Ensure each waiver amount is a valid number
    //         'student_id' => 'required|exists:users,id', // Ensure student_id is valid
    //     ], [
    //         // 'name.required'   => 'The name field is required.',
    //         // 'class.required'  => 'The class field is required.',
    //         // 'name.max'        => 'The name may not be greater than :max characters.',
    //         // 'name.unique'     => 'This name has already been taken.',
    //         // 'status.in'       => 'The status must be one of: active, inactive.',
    //     ]);

    //     if ($validator->fails()) {
    //         Session::flash('error', $validator->messages()->all());
    //         return redirect()->back()->withInput();
    //     }
    //     // Get the student ID
    //     $studentId = $request->input('student_id');

    //     // Loop through the selected fee IDs and their corresponding waived amounts
    //     foreach ($request->input('fee_id') as $feeId) {
    //         // Get the corresponding waiver amount for this fee
    //         $waivedAmount = $request->input("amount.$feeId");

    //         // If a waiver amount is provided (and not zero), create or update the waiver
    //         if ($waivedAmount > 0) {
    //             // Update or create the waiver record
    //             StudentFeeWaiver::updateOrCreate(
    //                 [
    //                     'student_id' => $studentId,  // Condition: Find waiver for the specific student and fee
    //                     'fee_id' => $feeId,  // Condition: for this fee
    //                 ],
    //                 [
    //                     'amount' => $waivedAmount,  // The waived amount
    //                     'status' => 'active',  // Set the waiver status to active
    //                     'added_by' => auth()->id(),  // Set the ID of the logged-in admin
    //                 ]
    //             );
    //         } else {
    //             // If waived amount is zero or empty, remove the waiver
    //             StudentFeeWaiver::where('student_id', $studentId)
    //                 ->where('fee_id', $feeId)
    //                 ->delete();
    //         }
    //     }

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Fee waivers updated successfully.');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
