<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\StudentInvoice;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        // Initialize filters
        $medium = $request->input('medium');
        $date = $request->input('date');
        $class = $request->input('class');
        $month = $request->input('month');
        $year = $request->input('year');

        // Date-wise collection
        $dateWiseCollection = DB::table('student_fees')
            ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
            ->join('users', 'student_fees.student_id', '=', 'users.id')
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('student_fees.paid_at', '=', $date);
            })
            ->when($medium, function ($query) use ($medium) {
                return $query->where('fees.medium', $medium);
            })
            ->where('student_fees.status', 'Paid')
            ->groupBy('student_fees.paid_at', 'fees.medium')
            ->select('student_fees.paid_at', 'fees.medium', DB::raw('SUM(student_fees.amount) as total_amount'))
            ->get()
            ->map(function ($item) {
                // Format the date to a more readable format
                $item->paid_at = Carbon::parse($item->paid_at)->format('Y-m-d');
                return $item;
            });

        // Class-wise collection
        $classWiseCollection = DB::table('student_fees')
            ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
            ->join('users', 'student_fees.student_id', '=', 'users.id')
            ->when($class, function ($query) use ($class) {
                return $query->whereJsonContains('fees.class', $class);
            })
            ->when($medium, function ($query) use ($medium) {
                return $query->where('fees.medium', $medium);
            })
            ->where('student_fees.status', 'Paid')
            ->groupBy('fees.class')
            ->select('fees.class', DB::raw('SUM(student_fees.amount) as total_amount'))
            ->get()
            ->map(function ($item) {
                // Decode the JSON class field
                $item->class = json_decode($item->class);
                return $item;
            });

        // Month/Year-wise collection
        $monthYearWiseCollection = DB::table('student_fees')
            ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
            ->when($month, function ($query) use ($month) {
                return $query->where('student_fees.month', $month);
            })
            ->when($year, function ($query) use ($year) {
                return $query->where('student_fees.year', $year);
            })
            ->when($medium, function ($query) use ($medium) {
                return $query->where('fees.medium', $medium);
            })
            ->where('student_fees.status', 'Paid')
            ->groupBy('student_fees.month', 'student_fees.year')
            ->select('student_fees.month', 'student_fees.year', DB::raw('SUM(student_fees.amount) as total_amount'))
            ->get();

        // Total collection report
        $totalCollection = DB::table('student_fees')
            ->join('fees', 'student_fees.fee_id', '=', 'fees.id')
            ->when($medium, function ($query) use ($medium) {
                return $query->where('fees.medium', $medium);
            })
            ->where('student_fees.status', 'Paid')
            ->sum('student_fees.amount');

        // Return the view with filtered data
        return view('admin.pages.report.fee-dashboard', compact(
            'dateWiseCollection',
            'classWiseCollection',
            'monthYearWiseCollection',
            'totalCollection'
        ));
    }

    public function invoiceList(Request $request)
    {
        // Initialize filters
        $medium = $request->input('medium');
        $date = $request->input('date');
        $class = $request->input('class');
        $month = $request->input('month');
        $year = $request->input('year');

        $invoices = StudentInvoice::latest('id')->get();
        return view('admin.pages.report.invoiceList', compact(
            'invoices',
        ));
    }
}
