<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $currentMonth = date('M');
        $currentYear = Carbon::now()->year;   // Current year (e.g., 2025)

        // Query for current month's income
        $currentMonthIncome = DB::table('student_fees')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('status', 'paid')  // You can add 'paid' to ensure only paid fees are included
            ->sum('amount');  // Sum the 'amount' column

        $currentYearIncome = DB::table('student_fees')
            ->where('year', $currentYear)
            ->where('status', 'paid')
            ->sum('amount');

        $data = [
            'total_student' => User::count(),
            'currentMonthIncome' => $currentMonthIncome,
            'currentYearIncome' => $currentYearIncome,
        ];

        return view('admin.dashboard', $data);
    }
}
