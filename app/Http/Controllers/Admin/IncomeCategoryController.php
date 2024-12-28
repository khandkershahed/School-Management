<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class IncomeCategoryController extends Controller
{

    public function index()
    {
        $categorys = IncomeCategory::latest()->get();
        return view('admin.pages.incomeCategory.index', compact('categorys'));
    }
    public function create()
    {
        return view("admin.pages.incomeCategory.create");
    }
    public function store(Request $request)
    {
        $this->validateRequest($request);

        try {
            $code = generateCode(IncomeCategory::class, 'IC');
            IncomeCategory::create([
                'name'   => $request->name,
                'code'   => $code,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            return $this->redirectWithSuccess('Income Category Added Successfully');

        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function edit($id)
    {
        $data = [
            'category' => IncomeCategory::where('slug', $id)->firstOrFail(),
        ];
        return view("admin.pages.incomeCategory.edit", $data);
    }


    public function update(Request $request, string $id)
    {
        $category = IncomeCategory::findOrFail($id);
        $this->validateRequest($request, $category->id);

        try {
            $category->update($request->only('name', 'note', 'status'));
            return $this->redirectWithSuccess('Income Category Edited Successfully');

        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {
        IncomeCategory::findOrFail($id)->delete();
    }

    private function validateRequest(Request $request, $categoryId = null)
    {
        $uniqueRule = $categoryId ? 'unique:income_categories,name,' . $categoryId : 'unique:income_categories';

        $request->validate([
            'name' => 'required|string|max:50|' . $uniqueRule,
            'note' => 'nullable|string|max:255',
        ]);
    }

    private function redirectWithSuccess(string $message)
    {
        Session::flash('success', $message);
        return redirect()->route('admin.income-category.index');
    }

    private function redirectWithError(string $message)
    {
        Session::flash('error', $message);
        return redirect()->back()->withInput();
    }
}
