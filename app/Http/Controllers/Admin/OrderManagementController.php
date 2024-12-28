<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [

            'pendingOrdersCount' => Order::where('status', 'pending')->count(),
            'deliveredOrdersCount' => Order::where('status', 'delivered')->count(),
            'orders' => Order::with('orderItems')->latest('created_at')->get(),
        ];
        return view('admin.pages.orderManagement.index', $data);
    }

    public function orderDetails($id)
    {

        $data = [
            'order' => Order::with('orderItems', 'user')->where('id', $id)->first(),
        ];
        return view('admin.pages.orderManagement.orderDetails', $data);
    }
    public function orderReport(Request $request)
    {
        $query = Order::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('order_created_at', [$startDate, $endDate]);
        }
        $total_sale           = $query->sum('total_amount');
        $orders               = $query->with('orderItems')->latest('order_created_at')->get();
        $pendingOrdersCount   = $query->where('status', 'pending')->count();
        $deliveredOrdersCount = $query->where('status', 'delivered')->count();
        $data = [
            'total_sale'           => $total_sale,
            'pendingOrdersCount'   => $pendingOrdersCount,
            'deliveredOrdersCount' => $deliveredOrdersCount,
            'orders'               => $orders,
        ];
        if ($request->ajax()) {
            return view('admin.pages.orderManagement.partial.orderReportTable', $data)->render();
        }else{
            return view('admin.pages.orderManagement.orderReport', $data);
        }

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
        //
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
}
