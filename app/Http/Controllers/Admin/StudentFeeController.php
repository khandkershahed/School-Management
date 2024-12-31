<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use Dompdf\Options;
use App\Models\User;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Models\EducationMedium;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rmunate\Utilities\SpellNumber;

class StudentFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'mediums' => EducationMedium::get(),
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
                'year' => 'required|integer',
                'month' => 'required|integer',
            ]);

            // Get the student
            $student = User::findOrFail($request->student_id);

            // Store the student fee entries
            $totalAmount = 0;
            foreach ($request->fee_id as $feeId) {
                $fee = Fee::findOrFail($feeId);
                // Create student fee record
                $studentFee = StudentFee::create([
                    'student_id' => $student->id,
                    'fee_id' => $fee->id,
                    'year' => $request->year,
                    'month' => $request->month,
                    'status' => 'paid', // Default status is 'Unpaid'
                ]);

                $totalAmount += $fee->amount; // Accumulate total amount for the receipt
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

            // Generate PDF using Dompdf
            $pdf = $this->generateReceiptPDF($receiptData);

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
            return redirect()->back()->with('error', $e->getMessage());
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

    public function filter(Request $request)
    {
        // Get the student by name, roll, medium, and class
        $student = User::where('name', 'like', '%' . $request->name . '%')
            ->where('roll', $request->roll)
            ->where('medium_id', $request->medium_id)
            ->where('class', $request->class)
            ->first();

        // Get the student fees based on medium and class
        $fees = Fee::where('medium_id', $request->medium_id)
            ->where('class', $request->class)
            ->get();

        // Return the partial view with data
        return response()->view('admin.pages.studentFee.partial.studentFee', compact('student', 'fees'));
    }
}
