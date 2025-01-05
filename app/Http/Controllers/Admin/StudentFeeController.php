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
use Illuminate\Support\Facades\Storage;

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

    //     try {
    //         // Validate the incoming request
    //         $request->validate([
    //             'student_id' => 'required|exists:users,id',
    //             'fee_id' => 'required|array',
    //             'fee_id.*' => 'exists:fees,id',
    //             'year' => 'required|string',
    //             'month' => 'required|string',
    //         ]);

    //         // Get the student
    //         $student = User::findOrFail($request->student_id);

    //         // Store the student fee entries
    //         $totalAmount = 0;
    //         foreach ($request->fee_id as $feeId) {
    //             $fee = Fee::findOrFail($feeId);
    //             // Create student fee record
    //             $studentFee = StudentFee::create([
    //                 'student_id' => $student->id,
    //                 'fee_id' => $fee->id,
    //                 'year' => date('Y'),
    //                 'month' => date('M'),
    //                 'status' => 'paid', // Default status is 'Unpaid'
    //             ]);

    //             $totalAmount += $fee->amount; // Accumulate total amount for the receipt
    //         }

    //         // Prepare receipt data
    //         $receiptData = [
    //             'student' => $student,
    //             'fees' => Fee::whereIn('id', $request->fee_id)->get(),
    //             'totalAmount' => $totalAmount,
    //             'year' => $request->year,
    //             'month' => $request->month,
    //             'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
    //         ];

    //         // Generate PDF using Dompdf
    //         $pdf = $this->generateReceiptPDF($receiptData);

    //         // Generate the file path for saving the PDFs
    //         $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
    //         $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

    //         // Save the PDF files to storage
    //         Storage::disk('public')->put($studentPdfPath, $pdf->output());
    //         Storage::disk('public')->put($officePdfPath, $pdf->output());

    //         // Store file paths in the database
    //         $invoice_number = $request->student_id . '-' . date('d');
    //         StudentInvoice::create([
    //             'student_id'     => $invoice_number,
    //             'invoice_number' => $request->invoice_number,
    //             'month'          => $request->month,
    //             'year'           => $request->year,
    //             'total_amount'   => $request->total_amount,
    //             'generated_at'   => Carbon::now(),
    //             'invoice'        => $studentPdfPath,
    //         ]);
    //         OfficeInvoice::create([
    //             'student_id'     => $invoice_number,
    //             'invoice_number' => $request->invoice_number,
    //             'month'          => $request->month,
    //             'year'           => $request->year,
    //             'total_amount'   => $request->total_amount,
    //             'generated_at'   => Carbon::now(),
    //             'invoice'        => $officePdfPath,
    //         ]);

    //         // Commit the transaction after successful creation
    //         DB::commit();

    //         // Return the generated PDF as a download response
    //         return response()->stream(function () use ($pdf) {
    //             echo $pdf->output();
    //         }, 200, [
    //             "Content-Type" => "application/pdf",
    //             "Content-Disposition" => "inline; filename=receipt.pdf",
    //         ]);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if any error occurs
    //         DB::rollBack();
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    // public function store(Request $request)
    // {
    //     // Start a transaction to ensure atomicity
    //     DB::beginTransaction();

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
    //         ]);

    //         // Get the student
    //         $student = User::findOrFail($request->student_id);
    //         $invoiceNumber = $student->student_id . '-' . date('d');
    //         // Store the student fee entries and calculate total amount
    //         $totalAmount = 0;
    //         foreach ($request->fee_id as $index => $feeId) {
    //             $fee = Fee::findOrFail($feeId);

    //             // Calculate the final amount after applying any waivers
    //             $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;
    //             $finalAmount = max(0, $request->amount[$index] - $waiverAmount); // Ensure the amount doesn't go negative

    //             // Create student fee record in `student_fees`
    //             StudentFee::create([
    //                 'student_id' => $student->id,
    //                 'fee_id' => $fee->id,
    //                 'amount' => $finalAmount,
    //                 'invoice_number' => $invoiceNumber,
    //                 'month' => $request->month,
    //                 'year' => $request->year,
    //                 'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid', // Status is "Paid" if amount > 0
    //                 'paid_at' => $finalAmount > 0 ? Carbon::now() : null, // Set paid_at if payment is made
    //             ]);

    //             // Add the final amount to the total amount
    //             $totalAmount += $finalAmount;
    //         }

    //         // Prepare receipt data
    //         $receiptData = [
    //             'student' => $student,
    //             'fees' => Fee::whereIn('id', $request->fee_id)->get(),
    //             'totalAmount' => $totalAmount,
    //             'year' => $request->year,
    //             'month' => $request->month,
    //             'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
    //         ];

    //         // Generate PDF using Dompdf (adjust this as per your method)
    //         $pdf = $this->generateReceiptPDF($receiptData);

    //         // Generate file paths for storing the PDFs
    //         $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
    //         $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

    //         // Save the PDF files to storage
    //         Storage::disk('public')->put($studentPdfPath, $pdf->output());
    //         Storage::disk('public')->put($officePdfPath, $pdf->output());

    //         // Generate a unique invoice number


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

    //         // Return the generated PDF as a download response
    //         return response()->stream(function () use ($pdf) {
    //             echo $pdf->output();
    //         }, 200, [
    //             "Content-Type" => "application/pdf",
    //             "Content-Disposition" => "inline; filename=receipt.pdf",
    //         ]);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if any error occurs
    //         DB::rollBack();

    //         // Log the error for debugging
    //         Log::error('Error storing payment data: ', ['error' => $e->getMessage()]);

    //         // Return a generic error message
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    // public function store(Request $request)
    // {
    //     // Start a transaction to ensure atomicity
    //     DB::beginTransaction();

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
    //         ]);

    //         // Get the student
    //         $student = User::findOrFail($request->student_id);

    //         // Generate a unique invoice number
    //         // We use a combination of student ID and current timestamp to make it unique
    //         $invoiceNumber = $student->student_id . '-' . time();
    //         // Store the student fee entries and calculate total amount
    //         $totalAmount = 0;

    //         foreach ($request->fee_id as $index => $feeId) {
    //             $fee = Fee::findOrFail($feeId);

    //             // Check if there's a waiver for this fee
    //             $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;

    //             // Calculate the final amount after applying any waivers
    //             $finalAmount = $waiverAmount;
    //             $finalAmount = max(0, $finalAmount); // Ensure the amount doesn't go negative

    //             // Create student fee record in `student_fees`
    //             StudentFee::create([
    //                 'student_id' => $student->id,
    //                 'fee_id' => $fee->id,
    //                 'amount' => $finalAmount,
    //                 'invoice_number' => $invoiceNumber,
    //                 'month' => $request->month,
    //                 'year' => $request->year,
    //                 'status' => $finalAmount > 0 ? 'Paid' : 'Unpaid', // Status is "Paid" if amount > 0
    //                 'paid_at' => $finalAmount > 0 ? Carbon::now() : null, // Set paid_at if payment is made
    //             ]);

    //             // Add the final amount to the total amount
    //             $totalAmount += $finalAmount;
    //         }

    //         // Prepare receipt data
    //         $receiptData = [
    //             'student' => $student,
    //             'fees' => Fee::whereIn('id', $request->fee_id)->get(),
    //             'totalAmount' => $totalAmount,
    //             'year' => $request->year,
    //             'month' => $request->month,
    //             'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
    //         ];

    //         // Generate PDF using Dompdf (adjust this as per your method)
    //         $pdf = $this->generateReceiptPDF($receiptData);

    //         // Generate file paths for storing the PDFs
    //         $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
    //         $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

    //         // Save the PDF files to storage
    //         Storage::disk('public')->put($studentPdfPath, $pdf->output());
    //         Storage::disk('public')->put($officePdfPath, $pdf->output());

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

    //         // Return the generated PDF as a download response
    //         return response()->stream(function () use ($pdf) {
    //             echo $pdf->output();
    //         }, 200, [
    //             "Content-Type" => "application/pdf",
    //             "Content-Disposition" => "inline; filename=receipt.pdf",
    //         ]);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if any error occurs
    //         DB::rollBack();

    //         // Log the error for debugging
    //         Log::error('Error storing payment data: ', ['error' => $e->getMessage()]);

    //         // Return a generic error message
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }



    public function store(Request $request)
    {
        // Start a transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Validate the incoming request
            $request->validate([
                'student_id' => 'required|exists:users,id',
                'fee_id' => 'required|array',
                'fee_id.*' => 'exists:fees,id',
                'waiver_amount' => 'nullable|array',
                'waiver_amount.*' => 'numeric|min:0',
                'month' => 'required|string',
                'year' => 'required|string',
                'months' => 'nullable|array', // For monthly fees
            ]);

            // Get the student
            $student = User::findOrFail($request->student_id);

            // Generate a unique invoice number
            $invoiceNumber = $student->student_id . '-' . time();

            // Store the student fee entries and calculate total amount
            $totalAmount = 0;

            foreach ($request->fee_id as $index => $feeId) {
                $fee = Fee::findOrFail($feeId);

                // Check if there's a waiver for this fee
                $waiverAmount = isset($request->waiver_amount[$feeId]) ? $request->waiver_amount[$feeId] : 0;

                // Calculate the final amount after applying any waivers
                $finalAmount = $fee->amount - $waiverAmount;
                $finalAmount = max(0, $finalAmount); // Ensure the amount doesn't go negative

                // Handle Monthly Fees
                if ($fee->fee_type === 'monthly') {
                    // Get the selected months from the request (if any)
                    $selectedMonths = isset($request->months[$feeId]) ? $request->months[$feeId] : [];

                    foreach ($selectedMonths as $month) {
                        // Create student fee record for each selected month
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

                        // Add to the total amount
                        $totalAmount += $finalAmount;
                    }
                } else {
                    // For non-monthly fees, store as a single fee record
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

            // Prepare receipt data
            $receiptData = [
                'student' => $student,
                'fees' => Fee::whereIn('id', $request->fee_id)->get(),
                'totalAmount' => $totalAmount,
                'year' => $request->year,
                'month' => $request->month,
                'amount_in_words' => SpellNumber::value($totalAmount)->locale('en')->toLetters(),
            ];

            // Generate PDF using Dompdf (adjust this as per your method)
            $pdf = $this->generateReceiptPDF($receiptData);

            // Generate file paths for storing the PDFs
            $studentPdfPath = 'receipts/student_copy_' . $student->id . '_' . time() . '.pdf';
            $officePdfPath = 'receipts/office_copy_' . $student->id . '_' . time() . '.pdf';

            // Save the PDF files to storage
            Storage::disk('public')->put($studentPdfPath, $pdf->output());
            Storage::disk('public')->put($officePdfPath, $pdf->output());

            // Store the student invoice record in `student_invoices`
            StudentInvoice::create([
                'student_id' => $student->id,
                'invoice_number' => $invoiceNumber,
                'month' => $request->month,
                'year' => $request->year,
                'total_amount' => $totalAmount,
                'generated_at' => Carbon::now(),
                'invoice' => $studentPdfPath, // Path to student copy
            ]);

            // Store the office invoice record in `office_invoices`
            OfficeInvoice::create([
                'student_id' => $student->id,
                'invoice_number' => $invoiceNumber,
                'month' => $request->month,
                'year' => $request->year,
                'total_amount' => $totalAmount,
                'generated_at' => Carbon::now(),
                'invoice' => $officePdfPath, // Path to office copy
            ]);

            // Commit the transaction after successful creation
            DB::commit();

            // Return the generated PDF as a download response
            return response()->stream(function () use ($pdf) {
                echo $pdf->output();
            }, 200, [
                "Content-Type" => "application/pdf",
                "Content-Disposition" => "inline; filename=receipt.pdf",
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();

            // Log the error for debugging
            Log::error('Error storing payment data: ', ['error' => $e->getMessage()]);

            // Return a generic error message
            return redirect()->back()->with('error', 'There was an error processing the payment.');
        }
    }


    public function generateReceiptPDF($data)
    {
        // Set up Dompdf options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Load view to generate the PDF content
        $pdf = Pdf::loadView('pdf.paymentReceipt', $data);

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

    // public function filter(Request $request)
    // {
    //     // Start with the query builder to find the student
    //     $query = User::query();

    //     // Apply search filters based on the request parameters
    //     if ($request->has('student_id') && $request->student_id !== '') {
    //         $query->where('student_id', $request->student_id);
    //     }

    //     if ($request->has('name') && !empty($request->name)) {
    //         $query->orWhere('name', 'like', '%' . $request->name . '%');
    //     }

    //     if ($request->has('roll') && $request->roll !== '') {
    //         $query->orWhere('roll', $request->roll);
    //     }

    //     if ($request->has('medium') && $request->medium !== '') {
    //         $query->orWhere('medium', $request->medium);
    //     }

    //     if ($request->has('class') && $request->class !== '') {
    //         $query->orWhereJsonContains('class', $request->class);
    //     }

    //     // dd($query);

    //     // Execute the query to find the student (first or null)
    //     $student = $query->first();

    //     if (!$student) {
    //         // If no student is found, return a special message
    //         return response()->json(['error' => 'Student not found']);
    //     }

    //     // Get the student fees based on medium and class
    //     $fees = Fee::where('medium', $student->medium)
    //         ->whereJsonContains('class', $student->class)
    //         ->where('status', 'active')
    //         ->get();

    //     // Return the partial view with data
    //     return response()->view('admin.pages.studentFee.partial.studentFee', compact('student', 'fees'));
    // }

    // public function filter(Request $request)
    // {
    //     // Start with the query builder to find the student
    //     $query = User::query();

    //     // Apply search filters based on the request parameters
    //     if ($request->has('student_id') && $request->student_id !== '') {
    //         $query->where('student_id', $request->student_id);
    //     }

    //     if ($request->has('name') && !empty($request->name)) {
    //         $query->orWhere('name', 'like', '%' . $request->name . '%');
    //     }

    //     if ($request->has('roll') && $request->roll !== '') {
    //         $query->orWhere('roll', $request->roll);
    //     }

    //     if ($request->has('medium') && $request->medium !== '') {
    //         $query->orWhere('medium', $request->medium);
    //     }

    //     if ($request->has('class') && $request->class !== '') {
    //         $query->orWhereJsonContains('class', $request->class);
    //     }

    //     // Execute the query to find the student (first or null)
    //     $student = $query->first();

    //     if (!$student) {
    //         // If no student is found, return a special message
    //         return response()->json(['error' => 'Student not found']);
    //     }

    //     // Get the student fees based on medium and class
    //     $fees = Fee::where('medium', $student->medium)
    //         ->whereJsonContains('class', $student->class)
    //         ->where('status', 'active')
    //         ->get();

    //     // Retrieve any waivers for the student
    //     $waivers = DB::table('student_fee_waivers')
    //         ->where('student_id', $student->id)
    //         ->get();

    //     // Create a lookup for the waivers to easily access by fee ID
    //     $waiversLookup = $waivers->keyBy('fee_id');

    //     // Return the partial view with data
    //     return response()->view('admin.pages.studentFee.partial.studentFee', compact('student', 'fees', 'waiversLookup'));
    // }

    // public function filter(Request $request)
    // {
    //     // Start with the query builder to find the student
    //     $query = User::query();

    //     // Apply search filters based on the request parameters
    //     if ($request->has('student_id') && $request->student_id !== '') {
    //         $query->where('student_id', 'like', '%' . $request->student_id . '%');
    //     }

    //     if ($request->has('name') && !empty($request->name)) {
    //         $query->orWhere('name', 'like', '%' . $request->name . '%');
    //     }

    //     if ($request->has('roll') && $request->roll !== '') {
    //         $query->orWhere('roll', $request->roll);
    //     }

    //     if ($request->has('medium') && $request->medium !== '') {
    //         $query->orWhere('medium', $request->medium);
    //     }

    //     if ($request->has('class') && $request->class !== '') {
    //         $query->orWhereJsonContains('class', $request->class);
    //     }

    //     // Execute the query to find the student (first or null)
    //     $student = $query->first();

    //     if (!$student) {
    //         // If no student is found, return a special message
    //         return response()->json(['error' => 'Student not found']);
    //     }

    //     // Get the student fees based on medium and class
    //     $fees = Fee::where('medium', $student->medium)
    //         ->whereJsonContains('class', $student->class)
    //         ->where('status', 'active')
    //         ->get();

    //     // Retrieve any waivers for the student
    //     $waivers = DB::table('student_fee_waivers')
    //         ->where('student_id', $student->id)
    //         ->get();

    //     // Create a lookup for the waivers to easily access by fee ID
    //     $waiversLookup = $waivers->keyBy('fee_id');

    //     // Get the paid fees for the student (these should not show in the due fees section)
    //     $paidFees = StudentFee::where('student_id', $student->id)
    //         ->where('status', 'Paid')
    //         ->pluck('fee_id'); // Get only the fee IDs of the paid fees

    //     // Exclude the paid fees from the list of available fees for the due fees section
    //     $dueFees = $fees->whereNotIn('id', $paidFees);

    //     // Return the partial view with data
    //     return response()->view('admin.pages.studentFee.partial.studentFee', compact('student', 'dueFees', 'waiversLookup', 'paidFees'));
    // }

    public function filter(Request $request)
    {
        $query = User::query();

        if ($request->has('student_id') && $request->student_id !== '') {
            $studentId = $request->student_id;

            if (strpos($studentId, '-') !== false) {
                // Extract only the numeric part (e.g., 20259640 from EMM-20259640)
                $studentId = substr($studentId, strpos($studentId, '-') + 1);
            }

            // Search using the student_id (whether numeric part or full ID)
            $query->where('student_id', 'like', '%' . $studentId . '%');
        }

        // Search by other fields (name, roll, medium, class)
        if ($request->has('name') && !empty($request->name)) {
            $query->orWhere('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('roll') && $request->roll !== '') {
            $query->orWhere('roll', $request->roll);
        }

        if ($request->has('medium') && $request->medium !== '') {
            $query->orWhere('medium', $request->medium);
        }

        if ($request->has('class') && $request->class !== '') {
            $query->orWhereJsonContains('class', $request->class);
        }

        // Execute the query to find the student (first or null)
        $student = $query->first();

        if (!$student) {
            // If no student is found, return a special message
            return response()->json(['error' => 'Student not found']);
        }

        // Get the student fees based on medium and class
        $fees = Fee::where('medium', $student->medium)
            ->whereJsonContains('class', $student->class)
            ->where('status', 'active')
            ->get();

        // Retrieve any waivers for the student
        $waivers = DB::table('student_fee_waivers')
            ->where('student_id', $student->id)
            ->get();

        // Create a lookup for the waivers to easily access by fee ID
        $waiversLookup = $waivers->keyBy('fee_id');

        // Get the paid fees for the student (these should not show in the due fees section)
        $paidFees = StudentFee::where('student_id', $student->id)
            ->where('status', 'Paid')
            ->pluck('fee_id'); // Get only the fee IDs of the paid fees

        // Exclude the paid fees from the list of available fees for the due fees section
        $dueFees = $fees->whereNotIn('id', $paidFees);

        // Return the partial view with data
        return response()->view('admin.pages.studentFee.partial.studentFee', compact('student', 'dueFees', 'waiversLookup', 'paidFees'));
    }
}
