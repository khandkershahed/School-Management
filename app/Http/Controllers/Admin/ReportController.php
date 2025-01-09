<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    public function customReport(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'fee_id'    => 'nullable|exists:fees,id',
            'year'      => 'nullable|integer|between:2025,2030',  // Ensure year is within a valid range
            'group_by'  => 'nullable|in:daily,monthly,yearly',
            'from_date' => 'nullable|date',
            'to_date'   => 'nullable|date|after_or_equal:from_date',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->all());
            return redirect()->back()->withInput();
        }

        // Get filter inputs
        $year = $request->input('year');
        $group_by = $request->input('group_by');
        $fee_id = $request->input('fee_id');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        try {
            // Get active fee types for selection
            $fees = Fee::where('status', 'active')->get();

            // Initialize empty data to prevent errors if no filter is applied
            $incomes = collect();
            $totalAmount = 0;

            // Check if any filter is applied
            if ($fee_id || $year || $group_by || $from_date || $to_date) {
                // Start query to get incomes based on selected fee type and filters
                $query = DB::table('student_fees')
                    ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
                    ->select(
                        DB::raw("SUM(student_fees.amount) AS amount"),
                        DB::raw("MAX(fees.name) AS fee_name")  // Use MAX to aggregate the fee name
                    )
                    ->whereNotNull('student_fees.fee_id'); // Ensure fee_id is not null

                // Apply filters
                if ($fee_id) {
                    $query->where('student_fees.fee_id', $fee_id); // Filter by selected fee type
                }

                if ($year) {
                    $query->whereYear('student_fees.paid_at', $year); // Filter by year
                }

                if ($from_date) {
                    $query->whereDate('student_fees.paid_at', '>=', $from_date);
                }

                if ($to_date) {
                    $query->whereDate('student_fees.paid_at', '<=', $to_date);
                }

                // Grouping logic based on user selection (daily, monthly, yearly)
                if ($group_by == 'daily') {
                    $query->selectRaw("DATE(student_fees.paid_at) AS day")
                        ->groupBy(DB::raw("DATE(student_fees.paid_at), fees.name"));
                } elseif ($group_by == 'monthly') {
                    $query->selectRaw("DATE_FORMAT(student_fees.paid_at, '%M, %Y') AS month")
                        ->groupBy(DB::raw("YEAR(student_fees.paid_at), MONTH(student_fees.paid_at), DATE_FORMAT(student_fees.paid_at, '%M, %Y'), fees.name"));
                } elseif ($group_by == 'yearly') {
                    $query->selectRaw("YEAR(student_fees.paid_at) AS year")
                        ->groupBy(DB::raw("YEAR(student_fees.paid_at), fees.name"));
                }

                // Execute the query and get the incomes
                $incomes = $query->get();

                // Calculate total amount
                $totalAmount = $incomes->sum('amount');
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in custom report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Return view with results
        return view('admin.pages.report.customReport', compact('incomes', 'totalAmount', 'fees', 'group_by', 'year', 'fee_id', 'from_date', 'to_date'));
    }





    public function dueFee(Request $request)
    {
        // Get filter parameters from the request
        $class = $request->input('class');
        $student_id = $request->input('student_id');

        // Initialize the result arrays (empty by default)
        $dueMonthlyFees = [];
        $dueYearlyFees = [];

        // Query to get the students with optional filters
        $students = User::query()
            ->where('status', 'active') // Only active students
            ->when($class, function ($query) use ($class) {
                return $query->where('class', $class); // Filter by class
            })
            ->when($student_id, function ($query) use ($student_id) {
                return $query->where('id', $student_id); // Filter by student ID
            })
            ->get();

        // Only process fees if there are students (after applying filters)
        if ($students->isNotEmpty()) {
            // Iterate over each student to calculate the due fees
            foreach ($students as $student) {
                // Get all fees based on the student's class and medium
                $fees = Fee::whereJsonContains('class', $student->class)
                    ->where('medium', $student->medium)
                    ->get();

                // Process monthly fees (Unpaid)
                foreach ($fees as $fee) {
                    $paidFee = $student->studentFees()
                        ->where('fee_id', $fee->id)
                        ->where('status', 'Paid')
                        ->first();

                    // If the fee has not been paid, add it to the due fees
                    if (!$paidFee) {
                        if ($fee->fee_type === 'monthly') {
                            // Prevent duplicate fees for the same student
                            if (!in_array($fee->id, array_column($dueMonthlyFees[$student->id] ?? [], 'fee_id'))) {
                                $dueMonthlyFees[$student->id][] = [
                                    'fee_id' => $fee->id, // store fee_id to check duplicates
                                    'fee' => $fee,
                                    'amount' => $fee->amount,
                                    'status' => 'Unpaid',
                                ];
                            }
                        }
                    }
                }

                // Process yearly fees (Unpaid)
                foreach ($fees as $fee) {
                    if ($fee->fee_type === 'yearly') {
                        $paidFee = $student->studentFees()
                            ->where('fee_id', $fee->id)
                            ->where('status', 'Paid')
                            ->first();

                        // If the fee has not been paid, add it to the due fees
                        if (!$paidFee) {
                            // Prevent duplicate fees for the same student
                            if (!in_array($fee->id, array_column($dueYearlyFees[$student->id] ?? [], 'fee_id'))) {
                                $dueYearlyFees[$student->id][] = [
                                    'fee_id' => $fee->id, // store fee_id to check duplicates
                                    'fee' => $fee,
                                    'amount' => $fee->amount,
                                    'status' => 'Unpaid',
                                ];
                            }
                        }
                    }
                }
            }
        }

        // Return the view with the due fee data, including class and student filter options
        return view('admin.pages.report.dueFee', compact('students', 'dueMonthlyFees', 'dueYearlyFees', 'class', 'student_id'));
    }






    public function studentDue(Request $request)
    {
        return view('admin.pages.report.studentDue');
    }


    public function accountingBalance(Request $request)
    {
        try {
            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'year'      => 'nullable|integer|between:2025,2030',  // Ensure year is within a valid range
                'group_by'  => 'nullable|in:daily,monthly,yearly',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            if ($validator->fails()) {
                // Flash only the error messages
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Get filter inputs
            $year      = $request->input('year');
            $group_by  = $request->input('group_by');
            $from_date = $request->input('from_date');
            $to_date   = $request->input('to_date');

            // Start the query builder
            $query = DB::table('student_fees')
                ->join('student_invoices', 'student_fees.invoice_number', '=', 'student_invoices.invoice_number')
                ->select(
                    DB::raw("SUM(student_fees.amount) AS amount"),
                    DB::raw("CONCAT('January ', MAX(student_fees.year), ' - December ', MAX(student_fees.year)) AS academic_year")
                );

            // Only apply filters if they're provided
            if ($year) {
                $query->whereYear('student_invoices.generated_at', $year); // Filter by selected academic year
            }
            if ($from_date) {
                $query->whereDate('student_invoices.generated_at', '>=', $from_date);
            }
            if ($to_date) {
                $query->whereDate('student_invoices.generated_at', '<=', $to_date);
            }

            // Adjust the query based on the "group_by" option
            if ($group_by == 'daily') {
                $query->selectRaw("DATE(student_invoices.generated_at) AS day")
                    ->groupBy(DB::raw("DATE(student_invoices.generated_at)"));
            } elseif ($group_by == 'monthly') {
                $query->selectRaw("DATE_FORMAT(student_invoices.generated_at, '%M, %Y') AS month")
                    ->groupBy(DB::raw("YEAR(student_invoices.generated_at), MONTH(student_invoices.generated_at), student_invoices.generated_at"));
            } elseif ($group_by == 'yearly') {
                $query->selectRaw("YEAR(student_invoices.generated_at) AS year")
                    ->groupBy(DB::raw("YEAR(student_invoices.generated_at)"));
            }

            // Execute the query if any filters are applied
            if ($year || $group_by || $from_date || $to_date) {
                $incomes = $query->get();
            } else {
                // If no filter is applied, set the result to an empty collection
                $incomes = collect();
            }

            // Calculate total amount
            $totalAmount = $incomes->sum('amount');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in Accounting Balance report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', 'An error occurred while generating the report.');
        }

        return view('admin.pages.report.accountingBalance', compact('incomes', 'totalAmount', 'group_by', 'year', 'from_date', 'to_date'));
    }



    // Controller: AdminReportController.php (or your respective controller file)
    public function studentInvoice(Request $request)
    {
        // Get filter parameters from the request
        $class = $request->input('class');
        $student_id = $request->input('student_id');

        // Retrieve students (active only)
        $students = User::latest('id')->where('status', 'active')->get();

        // Start building the query for invoices
        $invoices = StudentInvoice::latest('id');

        // Apply filters if present
        if ($class) {
            // Filter invoices based on student class using a relationship
            $invoices->whereHas('student', function ($query) use ($class) {
                $query->where('class', $class);
            });
        }

        if ($student_id) {
            // Filter invoices by student_id
            $invoices->where('student_id', $student_id);
        }

        // Get the filtered invoices with pagination
        $invoices = $invoices->get();

        // Calculate total balance (if you need to display it in the view)
        $total_balance = $invoices->sum(function ($invoice) {
            return $invoice->total_amount - ($invoice->paid_amount ?? 0); // Adjust this based on your field names
        });

        // Return the view with the filtered data
        return view('admin.pages.report.studentInvoice', compact('students', 'invoices', 'total_balance', 'class', 'student_id'));
    }



    public function income(Request $request)
    {
        // Validate incoming request
        try {
            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'year'      => 'nullable|integer|between:2025,2030',  // Ensure year is within a valid range
                'group_by'  => 'nullable|in:daily,monthly,yearly',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                // Flash the error messages
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Get filter inputs
            $year      = $request->input('year');
            $group_by  = $request->input('group_by');
            $from_date = $request->input('from_date');
            $to_date   = $request->input('to_date');

            // Initialize variables
            $incomes = collect();
            $totalAmount = 0;

            // Check if any filter is applied before running the query
            if ($year || $group_by || $from_date || $to_date) {
                // Start the query builder
                $query = DB::table('student_fees')
                    ->join('student_invoices', 'student_fees.invoice_number', '=', 'student_invoices.invoice_number')
                    ->select(
                        DB::raw("SUM(student_fees.amount) AS amount"),
                        DB::raw("CONCAT('January ', MAX(student_fees.year), ' - December ', MAX(student_fees.year)) AS academic_year")
                    );

                // Apply academic year filter
                if ($year) {
                    $query->whereYear('student_invoices.generated_at', $year);
                }

                // Apply date range filters if provided
                if ($from_date) {
                    $query->whereDate('student_invoices.generated_at', '>=', $from_date);
                }
                if ($to_date) {
                    $query->whereDate('student_invoices.generated_at', '<=', $to_date);
                }

                // Adjust the query based on the "group_by" option
                if ($group_by == 'daily') {
                    $query->selectRaw("DATE(student_invoices.generated_at) AS day")
                        ->groupBy(DB::raw("DATE(student_invoices.generated_at)"));
                } elseif ($group_by == 'monthly') {
                    $query->selectRaw("DATE_FORMAT(student_invoices.generated_at, '%M, %Y') AS month")
                        ->groupBy(DB::raw("YEAR(student_invoices.generated_at), MONTH(student_invoices.generated_at), student_invoices.generated_at"));
                } elseif ($group_by == 'yearly') {
                    $query->selectRaw("YEAR(student_invoices.generated_at) AS year")
                        ->groupBy(DB::raw("YEAR(student_invoices.generated_at)"));
                }

                // Execute the query to get incomes
                $incomes = $query->get();

                // Calculate total amount
                $totalAmount = $incomes->sum('amount');
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in Accounting Balance report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Return the view with the results
        return view('admin.pages.report.income', compact('incomes', 'totalAmount', 'group_by', 'year', 'from_date', 'to_date'));
    }
}
