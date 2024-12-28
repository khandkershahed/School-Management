<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categorys = ExpenseCategory::latest('id')->get();
        return view('admin.pages.expenseCategory.index', compact('categorys'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        try {
            $code = generateCode(ExpenseCategory::class, 'EC');
            ExpenseCategory::create([
                'name'   => $request->name,
                'code'   => $code,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            return $this->redirectWithSuccess('Expense Category Added Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $this->validateRequest($request, $category->id);

        try {
            $category->update($request->only('name', 'note', 'status'));
            return $this->redirectWithSuccess('Expense Category Edited Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {
        ExpenseCategory::findOrFail($id)->delete();
    }

    private function validateRequest(Request $request, $categoryId = null)
    {
        $uniqueRule = $categoryId ? 'unique:expense_categories,name,' . $categoryId : 'unique:expense_categories';

        $request->validate([
            'name' => 'required|string|max:50|' . $uniqueRule,
            'note' => 'nullable|string|max:255',
        ]);
    }

    private function redirectWithSuccess(string $message)
    {
        Session::flash('success', $message);
        return redirect()->back();
    }

    private function redirectWithError(string $message)
    {
        Session::flash('error', $message);
        return redirect()->back()->withInput();
    }
}
