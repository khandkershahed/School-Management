<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use App\Models\IncomeSubCategory;
use Illuminate\Http\Request;

class IncomeSubCategoryController extends Controller
{


    public function index()
    {
        $data = [
        //   'categorys'    => IncomeCategory::latest()->get(['id','name']),
          'subcategorys' => IncomeSubCategory::latest()->get(),
        ];
        return view('admin.pages.incomeSubCategory.index', $data);
    }

    public function create()
    {
        $data = [
            'categorys'    => IncomeCategory::latest()->get(['id','name']),
          ];
       return view("admin.pages.incomeSubCategory.create",$data);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        try {
            $code = generateCode(IncomeSubCategory::class, 'ESC');
            IncomeSubCategory::create([
                'name'   => $request->name,
                'code'   => $code,
                'cat_id' => $request->cat_id,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            redirectWithSuccess('Income Sub Category Added Successfully');
            return redirect()->route('admin.income-subcategory.index');
        } catch (\Exception $e) {
            redirectWithError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $data = [
            'categorys'    => IncomeCategory::latest()->get(['id','name']),
            'subcategory'  => IncomeSubCategory::where('slug' , $id)->firstOrFail(),
          ];
       return view("admin.pages.incomeSubCategory.edit",$data);
    }

    public function update(Request $request, string $id)
    {
        $category = IncomeSubCategory::findOrFail($id);
        $this->validateRequest($request, $category->id);

        try {
            $category->update($request->only('name', 'cat_id', 'note', 'status'));
            redirectWithSuccess('Income Sub Category Edited Successfully');
            return redirect()->route('admin.income-subcategory.index');
        } catch (\Exception $e) {
            redirectWithError($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        IncomeSubCategory::findOrFail($id)->delete();
    }

    private function validateRequest(Request $request, $categoryId = null)
    {
        $uniqueRule = $categoryId ? 'unique:income_sub_categories,name,' . $categoryId : 'unique:income_sub_categories';

        $request->validate([
            'name' => 'required|string|max:50|' . $uniqueRule,
            'note' => 'required',
            'note' => 'nullable|string|max:255',
        ]);
    }
}
