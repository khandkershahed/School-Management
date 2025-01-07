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
            'year' => 'nullable|integer|between:2023,'.date('Y'),
            'group_by' => 'nullable|in:daily,monthly,yearly',
            'fee_id' => 'nullable|exists:fees,id',
            'from_date' => 'nullable|date|before_or_equal:to_date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            Session::flash('error',$validator);
            return redirect()->back()->withErrors($validator)->withInput();
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
                $query->whereYear('student_fees.created_at', $year); // Filter by year
            }

            if ($from_date) {
                $query->where('student_fees.created_at', '>=', $from_date);
            }

            if ($to_date) {
                $query->where('student_fees.created_at', '<=', $to_date);
            }

            // Grouping logic based on user selection (daily, monthly, yearly)
            if ($group_by == 'daily') {
                $query->selectRaw("DATE(student_fees.created_at) AS day")
                    ->groupBy(DB::raw("DATE(student_fees.created_at), fees.name"));
            } elseif ($group_by == 'monthly') {
                $query->selectRaw("DATE_FORMAT(student_fees.created_at, '%M, %Y') AS month")
                    ->groupBy(DB::raw("YEAR(student_fees.created_at), MONTH(student_fees.created_at), fees.name"));
            } elseif ($group_by == 'yearly') {
                $query->selectRaw("YEAR(student_fees.created_at) AS year")
                    ->groupBy(DB::raw("YEAR(student_fees.created_at), fees.name"));
            }

            // Execute the query
            $incomes = $query->get();

            // Calculate total amount
            $totalAmount = $incomes->sum('amount');

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in custom report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again later.');
        }

        // Return view with results
        return view('admin.pages.report.customReport', compact('incomes', 'totalAmount', 'fees', 'group_by', 'year', 'fee_id', 'from_date', 'to_date'));
    }


    public function dueFee(Request $request)
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
        $invoices = $invoices->paginate(10);

        // Calculate total balance (if you need to display it in the view)
        $total_balance = $invoices->sum(function ($invoice) {
            return $invoice->total_amount - ($invoice->paid_amount ?? 0); // Adjust this based on your field names
        });

        // Return the view with the filtered data
        return view('admin.pages.report.dueFee' , compact('students', 'invoices', 'total_balance'));
    }


    public function studentDue(Request $request)
    {
        return view('admin.pages.report.studentDue');
    }


    public function accountingBalance(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'year' => 'nullable|integer|between:2023,2027',  // Ensure year is within a valid range
            'group_by' => 'nullable|in:daily,monthly,yearly',
            'from_date' => 'nullable|date|before_or_equal:to_date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        if ($validator->fails()) {
            Session::flash('error',$validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get filter inputs
        $year = $request->input('year');
        $group_by = $request->input('group_by');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        try {
            // Start the query builder
            $query = DB::table('student_fees')
                ->join('student_invoices', 'student_fees.invoice_number', '=', 'student_invoices.invoice_number')
                ->select(
                    DB::raw("SUM(student_fees.amount) AS amount"),
                    DB::raw("CONCAT('January ', MAX(student_fees.year), ' - December ', MAX(student_fees.year)) AS academic_year")
                )
                ->whereYear('student_invoices.generated_at', $year); // Filter by selected academic year

            // Apply date range filters if provided
            if ($from_date) {
                $query->where('student_invoices.generated_at', '>=', $from_date);
            }
            if ($to_date) {
                $query->where('student_invoices.generated_at', '<=', $to_date);
            }

            // Adjust the query based on the "group_by" option
            if ($group_by == 'daily') {
                $query->selectRaw("DATE(student_invoices.generated_at) AS day")
                    ->groupBy(DB::raw("DATE(student_invoices.generated_at)"));
            } elseif ($group_by == 'monthly') {
                $query->selectRaw("DATE_FORMAT(student_invoices.generated_at, '%M, %Y') AS month")
                    ->groupBy(DB::raw("YEAR(student_invoices.generated_at), MONTH(student_invoices.generated_at)"));
            } elseif ($group_by == 'yearly') {
                $query->selectRaw("YEAR(student_invoices.generated_at) AS year")
                    ->groupBy(DB::raw("YEAR(student_invoices.generated_at)"));
            }

            // Execute the query
            $incomes = $query->get();

            // Calculate total amount
            $totalAmount = $incomes->sum('amount');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in Accounting Balance report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again later.');
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
        return view('admin.pages.report.studentInvoice', compact('students', 'invoices', 'total_balance'));
    }



    public function income(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'year' => 'nullable|integer|between:2023,2027',  // Ensure year is within a valid range
            'group_by' => 'nullable|in:daily,monthly,yearly',
            'from_date' => 'nullable|date|before_or_equal:to_date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
        ]);

        if ($validator->fails()) {
            Session::flash('error',$validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get filter inputs
        $year = $request->input('year');
        $group_by = $request->input('group_by');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        try {
            // Start the query builder
            $query = DB::table('student_fees')
                ->join('student_invoices', 'student_fees.invoice_number', '=', 'student_invoices.invoice_number')
                ->select(
                    DB::raw("SUM(student_fees.amount) AS amount"),
                    DB::raw("CONCAT('January ', MAX(student_fees.year), ' - December ', MAX(student_fees.year)) AS academic_year")
                )
                ->whereYear('student_invoices.generated_at', $year); // Filter by selected academic year

            // Apply date range filters if provided
            if ($from_date) {
                $query->where('student_invoices.generated_at', '>=', $from_date);
            }
            if ($to_date) {
                $query->where('student_invoices.generated_at', '<=', $to_date);
            }

            // Adjust the query based on the "group_by" option
            if ($group_by == 'daily') {
                $query->selectRaw("DATE(student_invoices.generated_at) AS day")
                    ->groupBy(DB::raw("DATE(student_invoices.generated_at)"));
            } elseif ($group_by == 'monthly') {
                $query->selectRaw("DATE_FORMAT(student_invoices.generated_at, '%M, %Y') AS month")
                    ->groupBy(DB::raw("YEAR(student_invoices.generated_at), MONTH(student_invoices.generated_at)"));
            } elseif ($group_by == 'yearly') {
                $query->selectRaw("YEAR(student_invoices.generated_at) AS year")
                    ->groupBy(DB::raw("YEAR(student_invoices.generated_at)"));
            }

            // Execute the query
            $incomes = $query->get();

            // Calculate total amount
            $totalAmount = $incomes->sum('amount');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Error in income report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', 'An error occurred while generating the report. Please try again later.');
        }

        return view('admin.pages.report.income', compact('incomes', 'totalAmount', 'group_by', 'year', 'from_date', 'to_date'));
    }
}
