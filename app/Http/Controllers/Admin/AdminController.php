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
        // Get the current year and month
        $currentYear = Carbon::now()->year;  // Current year (e.g., 2025)
        $currentMonth = Carbon::now()->month; // Current month (e.g., 1 for January)

        // Query for current month's income based on 'paid_at'
        $currentMonthIncome = DB::table('student_fees')
            ->whereYear('paid_at', $currentYear) // Filter by current year
            ->whereMonth('paid_at', $currentMonth) // Filter by current month
            ->where('status', 'paid')  // Only include paid fees
            ->sum('amount');  // Sum the 'amount' column

        // Query for current year's income based on 'paid_at'
        $currentYearIncome = DB::table('student_fees')
            ->whereYear('paid_at', $currentYear) // Filter by current year
            ->where('status', 'paid')  // Only include paid fees
            ->sum('amount');  // Sum the 'amount' column

        // Prepare data for the dashboard view
        $data = [
            'total_student' => User::count(), // Total number of students (assuming users are students)
            'currentMonthIncome' => $currentMonthIncome,
            'currentYearIncome' => $currentYearIncome,
        ];

        // Return the view with data
        return view('admin.dashboard', $data);
    }
}
