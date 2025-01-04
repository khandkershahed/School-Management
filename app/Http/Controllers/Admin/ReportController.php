<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StudentInvoice;
use App\Http\Controllers\Controller;
use App\Models\User;

class ReportController extends Controller
{
    public function dueFee(Request $request)
    {
        return view('admin.pages.report.dueFee');
    }
    public function studentDue(Request $request)
    {
        return view('admin.pages.report.studentDue');
    }
    public function studentInvoice(Request $request)
    {
        $class = $request->input('class');
        $student_id = $request->input('student_id');
        $students = User::latest('id')->where('status','active')->get();
        $invoices = StudentInvoice::latest('id')->get();
        return view('admin.pages.report.studentInvoice', compact(
            'students',
            'invoices',
        ));
    }

    public function income(Request $request)
    {
        $class = $request->input('class');
        $student_id = $request->input('student_id');
        $students = User::latest('id')->where('status','active')->get();
        $invoices = StudentInvoice::latest('id')->get();
        return view('admin.pages.report.income', compact(
            'students',
            'invoices',
        ));
    }
}
