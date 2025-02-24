<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\User;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Models\StudentInvoice;
use App\Models\StudentFeeWaiver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesLog;
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

                // Groupinglogic based on user selection (daily, monthly, yearly)
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
            //Log the error for debugging
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
            //Log the error for debugging
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


        // Start building the query for invoices
        $invoices = StudentInvoice::latest('id');

        // Apply filters if present
        if ($class) {
            $students = User::latest('id')->where('class', $class)->where('status', 'active')->get();
            // Filter invoices based on student class using a relationship
            $invoices->whereHas('student', function ($query) use ($class) {
                $query->where('class', $class);
            });
        } else {
            $students = User::latest('id')->where('status', 'active')->get();
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
            //Log the error for debugging
            Log::error("Error in Accounting Balance report query: " . $e->getMessage());

            // Return a user-friendly message and redirect back
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Return the view with the results
        return view('admin.pages.report.income', compact('incomes', 'totalAmount', 'group_by', 'year', 'from_date', 'to_date'));
    }


    public function dailyTransaction(Request $request)
    {
        try {
            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'date' => 'nullable|date',
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Get filter inputs
            $date = $request->input('date');
            $incomes = collect();
            $totalAmount = 0;

            // Check if any filter is applied before running the query
            if ($date) {
                // Ensure the date is formatted correctly as 'Y-m-d'
                $date = Carbon::parse($date)->format('Y-m-d');
                Log::info('Formatted Date: ' . $date);  //Log the formatted date for debugging

                // Start the query builder
                $query = DB::table('student_invoices')
                    ->join('student_fees', 'student_invoices.student_id', '=', 'student_fees.student_id')
                    ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
                    ->join('users', 'student_invoices.student_id', '=', 'users.id')
                    ->leftJoin('student_fee_waivers', function ($join) {
                        $join->on('student_fees.fee_id', '=', 'student_fee_waivers.fee_id')
                            ->on('student_invoices.student_id', '=', 'student_fee_waivers.student_id');
                    })
                    ->select(
                        'users.student_id',
                        'fees.name AS fee_type',
                        DB::raw('IFNULL(student_fee_waivers.amount, 0) AS waived_amount'),
                        DB::raw('SUM(fees.amount) AS total_amount')
                    )
                    // Use whereDate to compare only the date part
                    ->whereDate('student_invoices.generated_at', '=', $date)
                    ->groupBy('users.student_id', 'fees.name', 'student_fee_waivers.amount');

                // Get the results
                $incomes = $query->get();

                $totalAmount = $incomes->sum(function ($income) {
                    return $income->total_amount - $income->waived_amount;
                });
            } else {
                // If no date is provided, you can optionally return all data or handle it differently
                $incomes = collect();  // Empty collection if no date filter
            }

            //Log the result to check if there is any data
            Log::info('Incomes Data: ', $incomes->toArray());
        } catch (\Exception $e) {
            //Log the error for debugging
            Log::error("Error in dailyTransaction query: " . $e->getMessage());
            Session::flash('error', $e->getMessage());
            // Return a user-friendly message and redirect back
            return redirect()->back();
        }

        // Return the view with the incomes data
        return view('admin.pages.report.dailyTransaction', compact('date', 'incomes', 'totalAmount'));
    }

    public function dailynetIncome(Request $request)
    {
        try {
            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $date = $request->input('date');
            $invoices = collect();

            if ($date) {
                $date = Carbon::parse($date)->format('Y-m-d');
                Log::info('Formatted Date: ' . $date);
                $invoices = DB::table('student_invoices')
                    ->whereDate('student_invoices.generated_at', '=', $date)
                    ->get();
            } else {
                $invoices = collect();  // Return empty collection if no date filter is applied
            }
            // dd($invoices);
        } catch (\Exception $e) {
            Log::error("Error in Daily Net Income query: " . $e->getMessage());
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

        // Return the view with the invoices data
        return view('admin.pages.report.dailynetIncome', compact('date', 'invoices'));
    }
    // public function dailynetIncome(Request $request)
    // {
    //     try {
    //         // Validate the request inputs
    //         $validator = Validator::make($request->all(), [
    //             'date' => 'nullable|date',
    //         ]);

    //         if ($validator->fails()) {
    //             Session::flash('error', $validator->errors()->all());
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $date = $request->input('date');
    //         $invoices = collect();

    //         if ($date) {
    //             $date = Carbon::parse($date)->format('Y-m-d');
    //            Log::info('Formatted Date: ' . $date);
    //             $invoices = DB::table('student_invoices')
    //                 ->whereDate('student_invoices.generated_at', '=', $date)
    //                 ->get();
    //         } else {
    //             $invoices = collect();  // Return empty collection if no date filter is applied
    //         }
    //         // dd($invoices);
    //     } catch (\Exception $e) {
    //        Log::error("Error in Daily Net Income query: " . $e->getMessage());
    //         Session::flash('error', $e->getMessage());
    //         return redirect()->back();
    //     }

    //     // Return the view with the invoices data
    //     return view('admin.pages.report.dailynetIncome', compact('date', 'invoices'));
    // }

    // public function dailyLedger(Request $request)
    // {
    //     try {
    //         // Validate date input
    //         $validator = Validator::make($request->all(), [
    //             'date' => 'nullable|date',
    //         ]);

    //         if ($validator->fails()) {
    //             Session::flash('error', $validator->errors()->all());
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $date = $request->input('date');
    //         $incomes = collect();
    //         $totalAmount = 0;

    //         if ($date) {
    //             // Ensure the date is formatted correctly as 'Y-m-d'
    //             $date = Carbon::parse($date)->format('Y-m-d');
    //            Log::info('Formatted Date: ' . $date);  //Log the formatted date for debugging

    //             // Fetch all fee types and their total amounts for the selected date
    //             $incomes = DB::table('student_invoices')
    //                 ->join('student_fees', 'student_invoices.student_id', '=', 'student_fees.student_id')
    //                 ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
    //                 ->leftJoin('student_fee_waivers', function ($join) {
    //                     $join->on('student_fees.fee_id', '=', 'student_fee_waivers.fee_id')
    //                         ->on('student_invoices.student_id', '=', 'student_fee_waivers.student_id');
    //                 })
    //                 ->select(
    //                     'fees.name AS fee_type',
    //                     DB::raw('SUM(fees.amount) AS total_amount'),
    //                     DB::raw('IFNULL(SUM(student_fee_waivers.amount), 0) AS waived_amount')
    //                 )
    //                 ->whereDate('student_invoices.generated_at', '=', $date)
    //                 ->groupBy('fees.name')
    //                 ->get();

    //             // Calculate total amount after waivers
    //             $totalAmount = $incomes->sum(function ($income) {
    //                 return $income->total_amount - $income->waived_amount;
    //             });
    //         }

    //         // Handle case where no date is selected
    //         if (!$date) {
    //             $incomes = collect();
    //         }
    //     } catch (\Exception $e) {
    //        Log::error("Error in Ledger Report query: " . $e->getMessage());
    //         Session::flash('error', $e->getMessage());
    //         return redirect()->back();
    //     }

    //     return view('admin.pages.report.dailyLedger', compact('date', 'incomes', 'totalAmount'));
    // }
    public function dailyLedger(Request $request)
    {
        try {
            // Validate date input
            $validator = Validator::make($request->all(), [
                'date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $date = $request->input('date');
            $incomes = collect();
            $totalAmount = 0;

            if ($date) {
                // Ensure the date is formatted correctly as 'Y-m-d'
                $date = Carbon::parse($date)->format('Y-m-d');
                Log::info('Formatted Date: ' . $date);  //Log the formatted date for debugging

                // Fetch all fees from the fees table along with the total amount based on the selected date
                $incomes = DB::table('fees')
                    ->leftJoin('student_fees', 'fees.id', '=', 'student_fees.fee_id')
                    ->select(
                        'fees.name AS fee_type',
                        DB::raw('IFNULL(SUM(student_fees.amount), 0) AS total_amount')
                    )
                    ->whereDate('student_fees.paid_at', '=', $date)
                    ->orWhereNull('student_fees.paid_at')  // Include fees even if no invoice exists for the date
                    ->groupBy('fees.id', 'fees.name')
                    ->get();

                // Calculate total amount for the report
                $totalAmount = $incomes->sum('total_amount');
            }

            // Handle case where no date is selected
            if (!$date) {
                $incomes = collect();
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

        return view('admin.pages.report.dailyLedger', compact('date', 'incomes', 'totalAmount'));
    }

    public function monthlyDue(Request $request)
    {
        try {
            // Validate the inputs
            $validator = Validator::make($request->all(), [
                'group' => 'nullable|string',
                'class' => 'nullable',
                'from_month' => 'nullable|date_format:Y-m',
                'to_month' => 'nullable|date_format:Y-m',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withInput();
            }

            // Get the filter inputs
            $group = $request->input('group');
            $class = $request->input('class');
            $fromMonth = $request->input('from_month') ? Carbon::parse($request->input('from_month'))->startOfMonth() : Carbon::now()->startOfMonth();
            $toMonth = $request->input('to_month') ? Carbon::parse($request->input('to_month'))->endOfMonth() : Carbon::now()->endOfMonth();

            // Query the students based on filters
            $students = User::where('group', $group)->where('class', $class)->get();

            $monthly_dues = [];

            foreach ($students as $student) {
                $totalDueAmount = 0;
                $dueMonths = [];

                $fees = Fee::where('medium', $student->medium)
                    ->whereJsonContains('class', $student->class)
                    ->where('status', 'active')
                    ->where('fee_type', 'monthly')
                    ->get();

                foreach ($fees as $fee) {
                    $waived_amount = StudentFeeWaiver::where('fee_id', $fee->id)
                        ->where('student_id', $student->id)
                        ->first(['amount']);
                    $waived_amount = $waived_amount ? $waived_amount->amount : 0;
                    $paidMonths = $student->studentFees
                        ->where('fee_id', $fee->id)
                        ->pluck('month')
                        ->map(function ($date) {
                            return Carbon::parse($date)->format('M');
                        });

                    $allMonths = collect();
                    $currentMonth = $fromMonth->copy();

                    while ($currentMonth->lte($toMonth)) {
                        $allMonths->push($currentMonth->format('M'));
                        $currentMonth->addMonth();
                    }

                    $dueMonthsForFee = $allMonths->diff($paidMonths);

                    if ($dueMonthsForFee->isNotEmpty()) {
                        $totalDueAmount += ($fee->amount - $waived_amount) * $dueMonthsForFee->count();
                        $dueMonths[] = $dueMonthsForFee->join(', ');
                    }
                }

                if ($totalDueAmount > 0) {
                    $monthly_dues[] = [
                        'student_id' => $student->student_id,
                        'fee_type' => 'Monthly Fee',
                        'months' => implode(', ', $dueMonths),
                        'total_due_amount' => $totalDueAmount,
                    ];
                }
            }

            $grandTotalDueAmount = array_sum(array_column($monthly_dues, 'total_due_amount'));

            return view('admin.pages.report.monthlyDue', compact(
                'monthly_dues',
                'grandTotalDueAmount',
                'fromMonth',
                'toMonth',
                'group',
                'class'
            ));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function examDue(Request $request)
    {
        try {
            // Validate the inputs
            $validator = Validator::make($request->all(), [
                'group' => 'nullable|string',
                'class' => 'nullable',
                'fee_id' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                Session::flash('error', $validator->errors()->all());
                return redirect()->back()->withInput();
            }
            $filter_fees = Fee::where('status', 'active')
                ->where('fee_type', 'yearly')
                ->where('name', 'like', '%exam%')
                ->get();
            $group = $request->input('group');
            $fee_id = $request->input('fee_id');
            $class = $request->input('class');

            // Query the students based on filters
            $students = User::where('group', $group)->where('class', $class)->get();

            $monthly_dues = [];

            foreach ($students as $student) {
                $fee = Fee::findOrFail($fee_id);
                $paid_check = StudentFee::where('fee_id', $fee_id)->where('student_id', $student->id)->first();
                $waived_amount = StudentFeeWaiver::where('fee_id', $fee_id)
                    ->where('student_id', $student->id)
                    ->first(['amount']);
                    // dd($paid_check);
                $waived_amount = $waived_amount ? $waived_amount->amount : 0;
                if ($paid_check) {
                    // exit;
                }else{
                    $monthly_dues[] = [
                        'student_id' => $student->student_id,
                        'fee_type' => $fee->name,
                        'total_due_amount' => ($fee->amount - $waived_amount) ,
                    ];
                }
            }

            $grandTotalDueAmount = array_sum(array_column($monthly_dues, 'total_due_amount'));

            return view('admin.pages.report.examDue', compact(
                'monthly_dues',
                'grandTotalDueAmount',
                'group',
                'fee_id',
                'filter_fees',
                'class'
            ));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    // public function monthlyDue(Request $request)
    // {
    //     try {
    //         // Validate the inputs
    //         $validator = Validator::make($request->all(), [
    //             'group' => 'nullable|string',
    //             'class' => 'nullable|integer',
    //             'from_month' => 'nullable|date_format:Y-m',
    //             'to_month' => 'nullable|date_format:Y-m',
    //         ]);

    //         if ($validator->fails()) {
    //             Session::flash('error', $validator->errors()->all());
    //             return redirect()->back()->withInput();
    //         }

    //         // Get the filter inputs
    //         $group = $request->input('group');
    //         $class = $request->input('class');
    //         $fromMonth = $request->input('from_month') ? Carbon::parse($request->input('from_month'))->startOfMonth() : null;
    //         $toMonth = $request->input('to_month') ? Carbon::parse($request->input('to_month'))->endOfMonth() : null;

    //         // Default to current month if no range is provided
    //         if (!$fromMonth) {
    //             $fromMonth = Carbon::now()->startOfMonth();
    //         }
    //         if (!$toMonth) {
    //             $toMonth = Carbon::now()->endOfMonth();
    //         }

    //         // Query the students based on filters (group and class)
    //         $students = User::where('group', $group)->where('class', $class)->get();

    //         Log::info("Found " . $students->count() . " students matching the filter.");

    //         // Prepare data for monthly dues
    //         $monthly_dues = [];

    //         foreach ($students as $student) {
    //             // Reset variables for each student
    //             $dueMonths = [];
    //             $totalDueAmount = 0;

    //             // Log: Entering the loop for this student
    //             Log::info("Processing student: {$student->student_id}");

    //             // Step 1: Get all active monthly fees for the student based on their medium and class
    //             $fees = Fee::where('medium', $student->medium)
    //                 ->whereJsonContains('class', $student->class)
    //                 ->where('status', 'active')
    //                 ->where('fee_type', 'monthly')
    //                 ->get();

    //             // Log: Check if fees were found for this student
    //             Log::info("Fees found for student {$student->student_id}: " . $fees->count());

    //             // Step 2: Get the fee_ids that the student has already paid (from student_fees table)
    //             $paidFees = $student->studentFees;  // Get the paid fees with months
    //             Log::info("Paid fees count for student {$student->student_id}: " . $paidFees->count());

    //             // Step 3: Loop through each fee to determine if it's unpaid
    //             foreach ($fees as $fee) {
    //                 $paidMonths = [];
    //                 if ($fee->fee_type == 'monthly') {
    //                     // For monthly fees, we need to fetch all the months the student has paid for
    //                     $paidFeesForFee = $paidFees->where('fee_id', $fee->id);

    //                     foreach ($paidFeesForFee as $paidFee) {
    //                         // Collect the months the student has paid for this fee
    //                         $paidMonths[] = Carbon::parse($paidFee->paid_month)->format('M');
    //                     }

    //                     // For each month from the start to the end of the selected period, check if the student has paid
    //                     $allMonths = collect();  // Initialize an empty collection
    //                     $currentMonth = $fromMonth;
    //                     $endMonth = $toMonth;

    //                     while ($currentMonth->lte($endMonth)) {
    //                         $allMonths->push($currentMonth->format('M'));  // Push month abbreviation (e.g., 'Jan', 'Feb')
    //                         $currentMonth->addMonth();  // Increment by one month
    //                     }

    //                     // Filter out months already paid for this fee
    //                     $dueMonthsForFee = $allMonths->diff($paidMonths);

    //                     // Log: Check due months for this fee
    //                     Log::info("Student {$student->student_id} - Due months for fee {$fee->id}: " . implode(', ', $dueMonthsForFee->toArray()));

    //                     // Step 4: Calculate the due amount for the unpaid months
    //                     $feeAmountForStudent = 0;
    //                     foreach ($dueMonthsForFee as $dueMonth) {
    //                         $feeAmountForStudent += $fee->amount;
    //                     }

    //                     // If there is any due amount for the fee, add it to the total
    //                     if ($feeAmountForStudent > 0) {
    //                         $totalDueAmount += $feeAmountForStudent;
    //                         $dueMonths[] = implode(', ', $dueMonthsForFee->toArray()); // Convert Collection to Array
    //                     }
    //                 }
    //             }

    //             // Log: Check total due amount for this student
    //             Log::info("Student {$student->student_id} - Total due amount: {$totalDueAmount}");

    //             // Only include the student if they have a total due amount
    //             if ($totalDueAmount > 0) {
    //                 $monthly_dues[] = [
    //                     'student_id' => $student->student_id,
    //                     'fee_type' => 'Monthly Fee',
    //                     'months' => $dueMonths,
    //                     'total_due_amount' => $totalDueAmount,
    //                 ];
    //             }
    //         }

    //         // Log: Final check on all collected data
    //         Log::info("Collected monthly dues: " . print_r($monthly_dues, true));

    //         // Calculate grand total due amount
    //         $grandTotalDueAmount = array_sum(array_column($monthly_dues, 'total_due_amount'));

    //         // Return the view with the filtered data
    //         return view('admin.pages.report.monthlyDue', compact('monthly_dues', 'grandTotalDueAmount', 'fromMonth', 'toMonth', 'group', 'class'));
    //     } catch (\Exception $e) {
    //         Session::flash('error', $e->getMessage());
    //         return redirect()->back()->withInput();
    //     }
    // }
}
