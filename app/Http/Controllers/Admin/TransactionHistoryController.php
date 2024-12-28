<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;

class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view("admin.pages.transactionHistory.create");
    // }
    //return all transactions
    public function index(Request $request)
    {
        $data = [
            'transactions' => AccountTransaction::with('cashbookAccount', 'user')->latest()->get(),
        ];
        return view("admin.pages.transactionHistory.index", $data);
    }

    // search and return transactions
    public function filter(Request $request)
    {
        // Get the start and end date from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // If no date filter is provided, fetch all transactions
        if (!$startDate || !$endDate) {
            $transactions = AccountTransaction::with('cashbookAccount', 'user')
                ->latest()
                ->get();
        } else {
            // Query to filter the transactions based on the date range
            $transactions = AccountTransaction::with('cashbookAccount', 'user')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->latest()
                ->get();
        }

        // Return a view fragment (HTML table rows)
        return response()->view('admin.pages.transactionHistory.filter_table', compact('transactions'));
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
        return view("admin.pages.transactionHistory.edit");
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
