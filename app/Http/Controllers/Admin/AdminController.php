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
        // $currentMonth = Carbon::now()->month;
        // $lastMonth = Carbon::now()->subMonth()->month;

        // // Earnings
        // $earningsCurrentMonth = Order::whereMonth('created_at', $currentMonth)
        //     ->sum('total_amount');
        // $earningsLastMonth = Order::whereMonth('created_at', $lastMonth)
        //     ->sum('total_amount');
        // $earningsChange = $earningsLastMonth ? (($earningsCurrentMonth - $earningsLastMonth) / $earningsLastMonth) * 100 : 0;

        // // Orders
        // $ordersCurrentMonth = Order::whereMonth('created_at', $currentMonth)->count();
        // $ordersLastMonth = Order::whereMonth('created_at', $lastMonth)->count();
        // $ordersChange = $ordersLastMonth ? (($ordersCurrentMonth - $ordersLastMonth) / $ordersLastMonth) * 100 : 0;

        // // Average Daily Sales
        // $daysInMonth = Carbon::now()->daysInMonth;
        // $averageDailySales = $daysInMonth ? $earningsCurrentMonth / $daysInMonth : 0;

        // // New Customers This Month
        // $newCustomersCurrentMonth = User::whereMonth('created_at', $currentMonth)->count();

        // // Top Products
        // $categoryWiseSales = DB::table('categories')
        //     ->leftJoin('products', 'categories.id', '=', 'products.category_id')
        //     ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        //     ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
        //     ->whereMonth('orders.created_at', $currentMonth)
        //     ->groupBy('categories.id', 'categories.name')
        //     ->select(
        //         'categories.id as category_id',
        //         'categories.name as category_name',
        //         DB::raw('SUM(order_items.subtotal) as total_sales')
        //     )
        //     ->orderBy('total_sales', 'DESC')
        //     ->get();
        // $monthlySales = $this->getMonthlySalesData();

        // // Prepare data for the chart
        // $months = [];
        // $sales = [];

        // // Generate month labels
        // for ($i = 1; $i <= 12; $i++) {
        //     $months[] = Carbon::create()->month($i)->format('F'); // 'January', 'February', etc.
        //     $sales[] = Order::whereMonth('created_at', $i)
        //         ->whereYear('created_at', Carbon::now()->year) // Change to your desired year if needed
        //         ->sum('total_amount');
        // }
        // $daysBefore = 5;
        // $daysAfter = 5;

        // $today = Carbon::now();

        // $startDate = $today->copy()->subDays($daysBefore);
        // $endDate = $today->copy()->addDays($daysAfter);

        // $dates = [];
        // $salesData = [];

        // for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        //     $dates[] = $date->format('d M');
        //     $totalAmount = Order::whereDate('created_at', $date->format('Y-m-d'))->sum('total_amount');
        //     $salesData[] = $totalAmount;
        // }


        $data = [
            // 'pendingOrdersCount'       => Order::where('status', 'pending')->count(),
            // 'total_earnings'           => Order::where('status', 'delivered')->where('payment_status', 'paid')->sum('total_amount'),
            // 'orders'                   => Order::with('orderItems')->latest('created_at')->get(),
            // 'earningsCurrentMonth'     => $earningsCurrentMonth,
            // 'earningsChange'           => $earningsChange,
            // 'ordersCurrentMonth'       => $ordersCurrentMonth,
            // 'ordersLastMonth'          => $ordersLastMonth,
            // 'ordersChange'             => $ordersChange,
            // 'averageDailySales'        => $averageDailySales,
            // 'newCustomersCurrentMonth' => $newCustomersCurrentMonth,
            // 'categoryWiseSales'        => $categoryWiseSales,
            // 'months'                   => $months,
            // 'sales'                    => $sales,
            // 'dates'                    => $dates,
            // 'salesData'                => $salesData,
        ];

        return view('admin.dashboard', $data);
    }

    public function getMonthlySalesData()
    {
        $monthlySales = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(order_created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as total_sales'))
            ->whereNotNull('order_created_at')
            ->groupBy(DB::raw('DATE_FORMAT(order_created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        return $monthlySales;
    }
}
