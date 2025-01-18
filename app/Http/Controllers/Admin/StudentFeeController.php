<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Fee;
use Dompdf\Options;
use App\Models\User;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Models\OfficeInvoice;
use App\Models\StudentInvoice;
use App\Models\EducationMedium;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rmunate\Utilities\SpellNumber;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'student' => User::with('medium')->latest('id')->get(),
        ];

        return view("admin.pages.studentFee.index", $data);
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






    // public function store(Request $request)
    // {
    //     // Start a transaction to ensure atomicity
    //     DB::beginTransaction();
    //     dd($request->all());
    //     try {
    //         // Validate the incoming request
    //         $request->validate([
    //             'student_id' => 'required|exists:users,id',
    //             'fee_id' => 'required|array',
    //             'fee_id.*' => 'exists:fees,id',
    //             'waiver_amount' => 'nullable|array',
    //             'waiver_amount.*' => 'numeric|min:0',
    //             'month' => 'required|string',
    //             'year' => 'required|string',
    //             'months' => 'nullable|array', // For monthly fees
    //         ]);

    //         // Get the student
    //         $student = User::findOrFail($request->student_id);

    //         // Generate the date portion of the invoice number (YYYYMMDD)
    //         $currentDate = Carbon::now();
    //         $datePortion = $currentDate->format('Ymd'); // Format: 20250107

    //         // Get the latest invoice number for today (if any)
    //         $latestInvoice = StudentInvoice::whereDate('generated_at', $currentDate->toDateString())
    //             ->orderBy('invoice_number', 'desc')
    //             ->first();

    //         // Determine the next sequential number
    //         $nextNumber = 1; // Default to 1 if no invoices were generated today
    //         if ($latestInvoice) {
    //             // Increment the last invoice number by 1
    //             $nextNumber = (int)substr($latestInvoice->invoice_number, -3) + 1;
    //         }

    //         // Format the invoice number as YYYYMMDDNumber (e.g., 202501071, 202501072)
    //         $invoiceNumber = $datePortion . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    //         // Store the student fee entries and calculate total amount
    //         $totalAmount = 0;
    //         $feeDetails = []; // Collect fee details to pass to the PDF

    //         foreach ($request->fee_id as $index => $feeId) {
    //             $fee = Fee::findOrFail($feeId);

    //             // Check if there's a waiver for this fee
    //             $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;

    //             // Calculate the final amount after applying any waivers
    //             $finalAmount = $fee->amount - $waiverAmount;
    //             $finalAmount = max(0, $finalAmount); // Ensure the amount doesn't go negative

    //             // Add the fee details to the collection for PDF
    //             $feeDetails[] = [
    //                 'fee' => $fee,
    //                 'waiverAmount' => $waiverAmount,
    //                 'finalAmount' => $finalAmount
    //             ];

    //             // Handle Monthly Fees
    //             if ($fee->fee_type === 'monthly') {
    //                 // Get the selected months from the request (if any)
    //                 $selectedMonths = isset($request->months[$feeId]) ? $request->months[$feeId] : [];

    //                 foreach ($selectedMonths as $month) {
    //                     // Create student fee record for each selected month
    //                     StudentFee::create([
    //                         'student_id' => $student->id,
    //                         'fee_id' => $fee->id,
    //                         'amount' => $finalAmount,
    //                         'invoice_number' => $invoiceNumber,
    //                         'month' => Carbon::create()->month($month)->format('F'),  // Convert month number to month name
    //                         'year' => $request->year,
    //                         'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid',
    //                         'paid_at' => $finalAmount > 0 ? Carbon::now() : null,
    //                     ]);

    //                     // Add to the total amount
    //                     $totalAmount += $finalAmount;
    //                 }
    //             }
    //         }

    //         // Prepare receipt data
    //         $receiptData = [
    //             'student'         => $student,
    //             'feeDetails'      => $feeDetails,  // Pass fee details with waiver amount to PDF
    //             'totalAmount'     => $totalAmount,
    //             'invoiceNumber'   => $invoiceNumber,
    //             'year'            => $request->year,
    //             'month'           => $request->month,
    //             'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
    //         ];

    //         // Generate PDFs using your PDF methods
    //         $studentpdf = $this->generateStudentReceiptPDF($receiptData);
    //         $officepdf = $this->generateOfficeReceiptPDF($receiptData);

    //         // Generate file paths for storing the PDFs
    //         $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
    //         $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

    //         // Save the PDF files to storage
    //         Storage::disk('public')->put($studentPdfPath, $studentpdf->output());
    //         Storage::disk('public')->put($officePdfPath, $officepdf->output());

    //         // Store the student invoice record in `student_invoices`
    //         StudentInvoice::create([
    //             'student_id' => $student->id,
    //             'invoice_number' => $invoiceNumber,
    //             'month' => $request->month,
    //             'year' => $request->year,
    //             'total_amount' => $totalAmount,
    //             'generated_at' => Carbon::now(),
    //             'invoice' => $studentPdfPath, // Path to student copy
    //         ]);

    //         // Store the office invoice record in `office_invoices`
    //         OfficeInvoice::create([
    //             'student_id' => $student->id,
    //             'invoice_number' => $invoiceNumber,
    //             'month' => $request->month,
    //             'year' => $request->year,
    //             'total_amount' => $totalAmount,
    //             'generated_at' => Carbon::now(),
    //             'invoice' => $officePdfPath, // Path to office copy
    //         ]);

    //         // Commit the transaction after successful creation
    //         DB::commit();

    //         // Return URLs for the generated PDFs
    //         return response()->json([
    //             'success' => true,
    //             'studentPdfUrl' => Storage::url($studentPdfPath),
    //             'officePdfUrl' => Storage::url($officePdfPath),
    //         ]);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if any error occurs
    //         DB::rollBack();

    //         // Log the error for debugging
    //         Log::error('Error storing payment data: ', ['error' => $e->getMessage()]);

    //         // Return a generic error message
    //         return response()->json(['success' => false, 'message' => 'There was an error processing the payment.']);
    //     }
    // }

    // public function store(Request $request)
    // {
    //     // Start a transaction to ensure atomicity
    //     DB::beginTransaction();
    //     dd($request->all());
    //     try {
    //         // Validate the incoming request
    //         $request->validate([
    //             'student_id' => 'required|exists:users,id',
    //             'fee_id' => 'required|array',
    //             'fee_id.*' => 'exists:fees,id',
    //             'waiver_amount' => 'nullable|array',
    //             'waiver_amount.*' => 'numeric|min:0',
    //             'month' => 'required|string',
    //             'year' => 'required|string',
    //             'months' => 'nullable|array', // For monthly fees
    //         ]);

    //         // Get the student
    //         $student = User::findOrFail($request->student_id);

    //         // Generate the date portion of the invoice number (YYYYMMDD)
    //         $currentDate = Carbon::now();
    //         $datePortion = $currentDate->format('Ymd'); // Format: 20250107

    //         // Get the latest invoice number for today (if any)
    //         $latestInvoice = StudentInvoice::whereDate('generated_at', $currentDate->toDateString())
    //             ->orderBy('invoice_number', 'desc')
    //             ->first();

    //         // Determine the next sequential number
    //         $nextNumber = 1; // Default to 1 if no invoices were generated today
    //         if ($latestInvoice) {
    //             // Increment the last invoice number by 1
    //             $nextNumber = (int)substr($latestInvoice->invoice_number, -3) + 1;
    //         }

    //         // Format the invoice number as YYYYMMDDNumber (e.g., 202501071, 202501072)
    //         $invoiceNumber = $datePortion . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    //         // Store the student fee entries and calculate total amount
    //         $totalAmount = 0;
    //         $feeDetails = []; // Collect fee details to pass to the PDF


    //         foreach ($request->fee_id as $index => $feeId) {
    //             $fee = Fee::findOrFail($feeId);

    //             // Check if there's a waiver for this fee
    //             $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;

    //             // Calculate the final amount after applying any waivers
    //             $finalAmount = $fee->amount - $waiverAmount;
    //             $finalAmount = max(0, $finalAmount); // Ensure the amount doesn't go negative

    //             // Add the fee details to the collection for PDF
    //             $feeDetails[] = [
    //                 'fee' => $fee,
    //                 'waiverAmount' => $waiverAmount,
    //                 'finalAmount' => $finalAmount
    //             ];

    //             // Handle Monthly Fees
    //             if ($fee->fee_type === 'monthly') {
    //                 // Get the selected months from the request (if any)
    //                 $selectedMonths = isset($request->months[$feeId]) ? $request->months[$feeId] : [];

    //                 foreach ($selectedMonths as $month) {
    //                     // Create student fee record for each selected month
    //                     StudentFee::create([
    //                         'student_id' => $student->id,
    //                         'fee_id' => $fee->id,
    //                         'amount' => $finalAmount,
    //                         'invoice_number' => $invoiceNumber,
    //                         'month' => Carbon::create()->month($month)->format('F'),  // Convert month number to month name
    //                         'year' => $request->year,
    //                         'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid',
    //                         'paid_at' => $finalAmount > 0 ? Carbon::now() : null,
    //                     ]);

    //                     // Add to the total amount
    //                     $totalAmount += $finalAmount;
    //                 }
    //             } else {
    //                 // For non-monthly fees, store as a single fee record
    //                 StudentFee::create([
    //                     'student_id' => $student->id,
    //                     'fee_id' => $fee->id,
    //                     'amount' => $finalAmount,
    //                     'invoice_number' => $invoiceNumber,
    //                     'month' => $request->month,
    //                     'year' => $request->year,
    //                     'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid',
    //                     'paid_at' => $finalAmount > 0 ? Carbon::now() : null,
    //                 ]);

    //                 // Add to the total amount for non-monthly fees
    //                 $totalAmount += $finalAmount;
    //             }
    //         }

    //         // Prepare receipt data
    //         $receiptData = [
    //             'student'         => $student,
    //             'feeDetails'      => $feeDetails,  // Pass fee details with waiver amount to PDF
    //             'totalAmount'     => $totalAmount,
    //             'invoiceNumber'   => $invoiceNumber,
    //             'year'            => $request->year,
    //             'month'           => $request->month,
    //             'amount_in_words' => 'yugfauysdagsfdsadfsa',
    //             // 'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
    //         ];

    //         // Generate PDFs using your PDF methods
    //         $studentpdf = $this->generateStudentReceiptPDF($receiptData);
    //         $officepdf = $this->generateOfficeReceiptPDF($receiptData);

    //         // Generate file paths for storing the PDFs
    //         $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
    //         $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

    //         // Save the PDF files to storage
    //         Storage::disk('public')->put($studentPdfPath, $studentpdf->output());
    //         Storage::disk('public')->put($officePdfPath, $officepdf->output());

    //         // Store the student invoice record in `student_invoices`
    //         StudentInvoice::create([
    //             'student_id' => $student->id,
    //             'invoice_number' => $invoiceNumber,
    //             'month' => $request->month,
    //             'year' => $request->year,
    //             'total_amount' => $totalAmount,
    //             'generated_at' => Carbon::now(),
    //             'invoice' => $studentPdfPath, // Path to student copy
    //         ]);

    //         // Store the office invoice record in `office_invoices`
    //         OfficeInvoice::create([
    //             'student_id' => $student->id,
    //             'invoice_number' => $invoiceNumber,
    //             'month' => $request->month,
    //             'year' => $request->year,
    //             'total_amount' => $totalAmount,
    //             'generated_at' => Carbon::now(),
    //             'invoice' => $officePdfPath, // Path to office copy
    //         ]);

    //         // Commit the transaction after successful creation
    //         DB::commit();

    //         // Return URLs for the generated PDFs
    //         return response()->json([
    //             'success' => true,
    //             'studentPdfUrl' => Storage::url($studentPdfPath),
    //             'officePdfUrl' => Storage::url($officePdfPath),
    //         ]);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if any error occurs
    //         DB::rollBack();

    //         // Log the error for debugging
    //         Log::error('Error storing payment data: ', ['error' => $e->getMessage()]);

    //         // Return a generic error message
    //         return response()->json(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    public function store(Request $request)
    {
        // Start a transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'student_id' => 'required|exists:users,id',
                'year' => 'required|string',
                'month' => 'required|string',
                'fee_id' => 'nullable|array', // For non-monthly fees
                'fee_id.*' => 'exists:fees,id',
                'months' => 'nullable|array', // For monthly fees
                'months.*' => 'nullable|array', // For selecting months per fee
                'waiver_amount' => 'nullable|array',
                'waiver_amount.*' => 'numeric',
            ]);
            if ($validator->fails()) {
                // Flash only the error messages
                // Session::flash('error', $validator->errors()->all());
                return response()->json(['success' => false, 'message' =>  $validator->errors()->all()]);
                // return redirect()->back()->withErrors($validator)->withInput();
            }
            // Get the student
            $student = User::findOrFail($request->student_id);

            // Generate the date portion of the invoice number (YYYYMMDD)
            $currentDate = Carbon::now();
            $datePortion = $currentDate->format('Ymd'); // Format: 20250107

            // Get the latest invoice number for today (if any)
            $latestInvoice = StudentInvoice::whereDate('generated_at', $currentDate->toDateString())
                ->orderBy('invoice_number', 'desc')
                ->first();

            // Determine the next sequential number
            $nextNumber = 1; // Default to 1 if no invoices were generated today
            if ($latestInvoice) {
                // Increment the last invoice number by 1
                $nextNumber = (int)substr($latestInvoice->invoice_number, -3) + 1;
            }

            // Format the invoice number as YYYYMMDDNumber (e.g., 202501071, 202501072)
            $invoiceNumber = $datePortion . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Store the student fee entries and calculate total amount
            $totalAmount = 0;
            $feeDetails = []; // Collect fee details to pass to the PDF

            // Handle non-monthly fees (fee_id is provided directly)
            if ($request->has('fee_id')) {
                foreach ($request->fee_id as $feeId) {
                    $fee = Fee::findOrFail($feeId);

                    // Get the waiver if available
                    $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;

                    // Calculate the final amount after applying any waivers
                    $finalAmount = $fee->amount - $waiverAmount;
                    $finalAmount = max(0, $finalAmount); // Ensure the amount doesn't go negative

                    // Add the fee details to the collection for PDF
                    $feeDetails[] = [
                        'fee' => $fee->name,
                        'amount' => $fee->amount,
                        'waiverAmount' => $waiverAmount,
                        'finalAmount' => $finalAmount
                    ];

                    // Store the non-monthly fee record
                    StudentFee::create([
                        'student_id' => $student->id,
                        'fee_id' => $fee->id,
                        'amount' => $finalAmount,
                        'invoice_number' => $invoiceNumber,
                        'month' => $request->month,
                        'year' => $request->year,
                        'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid',
                        'paid_at' => $finalAmount > 0 ? Carbon::now() : null,
                    ]);

                    // Add to the total amount for non-monthly fees
                    $totalAmount += $finalAmount;
                }
            }

            // Handle monthly fees (months[fee_id] is provided)
            if ($request->has('months')) {
                foreach ($request->months as $feeId => $selectedMonths) {
                    $fee = Fee::findOrFail($feeId);

                    // Get the waiver if available
                    $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;

                    // Calculate the final amount after applying any waivers
                    $finalAmount = $fee->amount - $waiverAmount;
                    $finalAmount = max(0, $finalAmount); // Ensure the amount doesn't go negative



                    // For each month selected, store the fee record
                    foreach ($selectedMonths as $month) {
                        $fee_name = $fee->name . " (" . Carbon::create()->month($month)->format('F') . ")";
                        $feeDetails[] = [
                            'fee' => $fee_name,
                            'amount' => $fee->amount,
                            'waiverAmount' => $waiverAmount,
                            'finalAmount' => $finalAmount
                        ];
                        StudentFee::create([
                            'student_id' => $student->id,
                            'fee_id' => $fee->id,
                            'amount' => $finalAmount,
                            'invoice_number' => $invoiceNumber,
                            'month' => Carbon::create()->month($month)->format('F'),  // Convert month number to month name
                            'year' => $request->year,
                            'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid',
                            'paid_at' => $finalAmount > 0 ? Carbon::now() : null,
                        ]);

                        // Add to the total amount for monthly fees
                        $totalAmount += $finalAmount;
                    }
                }
            }

            // Prepare receipt data
            $receiptData = [
                'student'         => $student,
                'feeDetails'      => $feeDetails,  // Pass fee details with waiver amount to PDF
                'totalAmount'     => $totalAmount,
                'invoiceNumber'   => $invoiceNumber,
                'year'            => $request->year,
                'month'           => $request->month,
                'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
                // 'amount_in_words' => "hdnvdddfdsdsfdsfvd",
            ];

            // Generate PDFs using your PDF methods
            $studentpdf = $this->generateStudentReceiptPDF($receiptData);
            $officepdf = $this->generateOfficeReceiptPDF($receiptData);

            // Generate file paths for storing the PDFs
            $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
            $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

            // Save the PDF files to storage
            Storage::disk('public')->put($studentPdfPath, $studentpdf->output());
            Storage::disk('public')->put($officePdfPath, $officepdf->output());

            // Store the student invoice record in `student_invoices`
            StudentInvoice::create([
                'student_id'     => $student->id,
                'invoice_number' => $invoiceNumber,
                'month'          => $request->month,
                'year'           => $request->year,
                'total_amount'   => $totalAmount,
                'generated_at'   => Carbon::now(),
                'invoice'        => $studentPdfPath, // Path to student copy
            ]);

            // Store the office invoice record in `office_invoices`
            OfficeInvoice::create([
                'student_id'     => $student->id,
                'invoice_number' => $invoiceNumber,
                'month'          => $request->month,
                'year'           => $request->year,
                'total_amount'   => $totalAmount,
                'generated_at'   => Carbon::now(),
                'invoice'        => $officePdfPath, // Path to office copy
            ]);

            // Commit the transaction after successful creation
            DB::commit();

            // Return URLs for the generated PDFs
            return response()->json([
                'success' => true,
                'studentPdfUrl' => Storage::url($studentPdfPath),
                'officePdfUrl' => Storage::url($officePdfPath),
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error storing payment data: ', ['error' => $e->getMessage()]);

            // Return a generic error message
            return response()->json(['success' => false, 'message' =>  $e->getMessage()]);
        }
    }



    public function generateStudentReceiptPDF($data)
    {
        // Set up Dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Load view to generate the PDF content
        $pdf = Pdf::loadView('pdf.studentReceipt', $data);

        // Set paper size to one-fourth of A4 paper (105mm x 148.5mm)
        $pdf->setPaper('A4'); // Custom size (width, height)

        // Render PDF (first pass)
        $pdf->render();

        // Return the generated PDF
        return $pdf;
    }
    public function generateOfficeReceiptPDF($data)
    {
        // Set up Dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Load view to generate the PDF content
        $pdf = Pdf::loadView('pdf.officeReceipt', $data);

        // Set paper size to one-fourth of A4 paper (105mm x 148.5mm)
        $pdf->setPaper('A4'); // Custom size (width, height)

        // Render PDF (first pass)
        $pdf->render();

        // Return the generated PDF
        return $pdf;
    }


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


    public function filter(Request $request)
    {
        $query = User::query();

        if ($request->has('student_id') && $request->student_id !== '') {
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
        } else {
            // If student_id is not provided, filter by other fields (name, roll, medium, class)
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('roll') && $request->roll !== '') {
                $query->where('roll', $request->roll);
            }

            if ($request->has('medium') && $request->medium !== '') {
                $query->where('medium', $request->medium);
            }

            if ($request->has('class') && $request->class !== '') {
                $query->whereJsonContains('class', $request->class);
            }

            // Execute the query to find the student (first or null)
            $student = $query->first();

            // If no student is found, return an error
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'No student found matching the provided criteria.'
                ], 404);
            }
        }

        try {
            if ($student->student_type == 'old') {
                $fees = Fee::where('medium', $student->medium)
                    ->whereJsonContains('class', $student->class)
                    ->whereJsonContains('fee_package', 'session_charge')
                    ->where('status', 'active')
                    ->where('fee_type', '!=', 'monthly')->get();

                $package_name = 'Session Charge';
            } else {
                // For new students: Include fees without 'admission_charge' and fees with NULL/empty 'fee_package'
                $fees = Fee::where('medium', $student->medium)
                    ->whereJsonContains('class', $student->class)
                    ->whereJsonContains('fee_package', 'admission_charge')
                    ->where('status', 'active')
                    ->where('fee_type', '!=', 'monthly')->get();

                $package_name = 'Admission Charge';
            }

            // dd($fees);

            // Get monthly fees
            $monthly_fees = Fee::where('medium', $student->medium)
                ->whereJsonContains('class', $student->class)
                ->where('status', 'active')
                ->where('fee_type', 'monthly')
                ->get();

            $recurring_fees = Fee::where('medium', $student->medium)
                ->whereJsonContains('class', $student->class)
                ->where('status', 'active')
                ->where('fee_type', 'recurring')
                ->get();
            // Initialize the collection

            $exam_fees = Fee::where('status', 'active')
                ->where('fee_type', 'yearly')
                ->where('name', 'like', '%exam%')
                ->get();

            // Retrieve any waivers for the studentdd
            $waivers = DB::table('student_fee_waivers')
                ->where('student_id', $student->id)
                ->get();

            // Create a lookup for the waivers to easily access by fee ID
            $waiversLookup = $waivers->keyBy('fee_id');

            // Get the paid fees for the student (these should not show in the due fees section)
            $studentpaidFees = StudentFee::where('student_id', $student->id)
                ->where('status', 'Paid')
                ->get(); // Get only the fee IDs of the paid fees
            $paidFees = StudentFee::where('student_id', $student->id)
                ->where('status', 'Paid')
                ->pluck('fee_id'); // Get only the fee IDs of the paid fees

            // Exclude the paid fees from the list of available fees for the due fees section
            $dueFees = $fees->whereNotIn('id', $paidFees);
            $examdueFees = $exam_fees->whereNotIn('id', $paidFees);
        } catch (\Exception $e) {
            // Handle any errors that might occur during the database queries
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching data: ' . $e->getMessage()
            ], 500);
        }

        // Return the partial view with data
        return response()->view('admin.pages.studentFee.partial.studentFee', compact('student', 'package_name', 'examdueFees', 'exam_fees','dueFees', 'recurring_fees', 'waiversLookup', 'paidFees', 'monthly_fees', 'studentpaidFees'));
    }
}
