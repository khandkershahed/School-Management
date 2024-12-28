<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseReportController extends Controller
{
    public function index()
    {
        $data = [
            'expenses' => Expense::with('expSubCategory', 'expCategory', 'expTransaction.cashbookAccount', 'addUser', 'updateUser')->latest()->get(),
        ];
        return view('admin.pages.expenseReport.index', $data);
    }
}
