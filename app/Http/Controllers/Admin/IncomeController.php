<?php

namespace App\Http\Controllers\Admin;
use Exception;

use App\Models\Income;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\IncomeSubCategory;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    public function index()
    {
        $data = [
            'incomes' => Income::with('incomeSubCategory', 'incomeCategory', 'incomeTransaction.cashbookAccount', 'addUser', 'updateUser')->latest()->get(),
        ];
        return view('admin.pages.income.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'categories' => IncomeSubCategory::latest()->get(['id', 'name']),
            'accounts'   => Account::latest()->get(['id', 'bank_name', 'account_number']),
        ];
        return view('admin.pages.income.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'reason'        => 'nullable|string|max:255',
            'subCategory'   => 'nullable',
            'account_id'    => 'required',
            'amount'        => 'nullable|numeric|max:' . $request->availableBalance,
            'chequeNo'      => 'nullable|string|max:255',
            'voucherNo'     => 'nullable|string|max:255',
            'date'          => 'nullable|date_format:Y-m-d',
            'note'          => 'nullable|string|max:255',
        ], [
            'category_id.exists'        => 'The selected category does not exist.',
            'question.required'         => 'The question field is required.',
            'question.string'           => 'The question must be a string.',
            'question.max'              => 'The question may not be greater than :max characters.',
            'account_id.required'       => 'You must choose an account',
            'answer.string'             => 'The answer must be a string.',
            'tag.string'                => 'The tag must be a string.',
            'tag.max'                   => 'The tag may not be greater than :max characters.',
            'order.integer'             => 'The order must be an integer.',
            'order.min'                 => 'The order must be at least :min.',
            'order.unique'              => 'The order value has already been taken.',
            'status.required'           => 'The status field is required.',
            'status.in'                 => 'The status must be one of: active, inactive.',
            'views.integer'             => 'The views must be an integer.',
            'views.min'                 => 'The views must be at least :min.',
            'related_faqs.json'         => 'The related FAQs must be a valid JSON string.',
            'is_featured.boolean'       => 'The is featured field must be true or false.',
            'additional_info.string'    => 'The additional info must be a string.',
        ]);
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }
        try {
            // upload thumbnail and set the name
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'income/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }
            if (!empty($request->sub_cat_id)) {
                $subCategory = IncomeSubCategory::find($request->sub_cat_id);
                $cat_id = $subCategory ? $subCategory->cat_id : "";
            } else {
                $cat_id = "";
            }

            // store transaction
            $transaction = AccountTransaction::create([
                'account_id'       => $request->account_id,
                'amount'           => $request->amount,
                'reason'           => $request->reason,
                'type'             => 1,
                'transaction_date' => $request->date,
                'cheque_no'        => $request->chequeNo,
                'receipt_no'       => $request->voucherNo,
                'created_by'       => Auth::guard('admin')->user()->id,
                'status'           => $request->status,
            ]);

            // create income
            Income::create([
                'name'           => $request->reason,
                'reason'         => $request->reason,
                'sub_cat_id'     => $request->sub_cat_id,
                'amount'         => $request->amount,
                'cat_id'         => $cat_id,
                'transaction_id' => $transaction->id,
                'date'           => $request->date,
                'created_by'     => Auth::guard('admin')->user()->id,
                'note'           => $request->note,
                'image'          => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
                'status'         => $request->status,
            ]);
            redirectWithSuccess('Income Added Successfully');
            return redirect()->route('admin.income.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
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
        $data = [
            'income'    => Income::findOrFail($id),
            'categories' => IncomeSubCategory::latest()->get(['id', 'name']),
            'accounts'   => Account::latest()->get(['id', 'bank_name', 'account_number']),
        ];
        return view('admin.pages.income.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the income by ID
        $income = Income::findOrFail($id);

        // Validate the request
        $this->validate($request, [
            'reason'        => 'nullable|string|max:255',
            'sub_cat_id'    => 'nullable|exists:income_sub_categories,id',
            'account_id'    => 'nullable|exists:accounts,id',
            'amount'        => 'nullable|numeric|max:' . $request->availableBalance,
            'chequeNo'      => 'nullable|string|max:255',
            'voucherNo'     => 'nullable|string|max:255',
            'date'          => 'nullable|date_format:Y-m-d',
            'note'          => 'nullable|string|max:255',
            'image'         => 'nullable|image|max:2048', // Adjust as necessary
        ]);

        try {
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'income/' . $key;
                    $oldFile = $account->$key ?? null;

                    if ($oldFile) {
                        Storage::delete("public/" . $oldFile);
                    }
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Update the transaction
            $transaction = $income->incomeTransaction;
            $transaction->update([
                'account_id'       => $request->account_id,
                'amount'           => $request->amount,
                'reason'           => $request->reason,
                'transaction_date' => $request->date,
                'cheque_no'        => $request->chequeNo,
                'receipt_no'       => $request->voucherNo,
                'status'           => $request->status,
            ]);
            if (!empty($request->sub_cat_id)) {
                $subCategory = IncomeSubCategory::find($request->sub_cat_id);
                $cat_id = $subCategory ? $subCategory->cat_id : '';
            } else {
                $cat_id = '';
            }
            // Update the income
            $income->update([
                'name'           => $request->reason,
                'reason'         => $request->reason,
                'sub_cat_id'     => $request->sub_cat_id,
                'cat_id'         => $cat_id,
                'amount'         => $request->amount,
                'date'           => $request->date,
                'updated_by'     => Auth::guard('admin')->user()->id,
                'note'           => $request->note,
                'image'          => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $income->image,
                'status'         => $request->status,

            ]);

            redirectWithSuccess('Income Updated Successfully');
            return redirect()->route('admin.income.index');
        } catch (Exception $e) {
            // Handle the exception and redirect back with an error message
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $income = Income::where('id', $id)->first();
        $files = [
            'image' => $income->image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $income->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $income->delete();
    }

    public function search(Request $request)
    {
        $term = $request->term;
        $query = Income::with('incomeSubCategory.incomeCategory', 'incomeTransaction.cashbookAccount', 'user');

        if ($request->startDate && $request->endDate) {
            $query = $query->whereBetween('date', [$request->startDate, $request->endDate]);
        }

        $query->where(function ($query) use ($term) {
            $query->where('reason', 'LIKE', '%' . $term . '%')
                ->orWhereHas('incomeSubCategory', function ($newQuery) use ($term) {
                    $newQuery->where('name', 'LIKE', '%' . $term . '%')
                        ->orWhereHas('incomeCategory', function ($newQuery) use ($term) {
                            $newQuery->where('name', 'LIKE', '%' . $term . '%');
                        });
                })
                ->orWhereHas('incomeTransaction', function ($newQuery) use ($term) {
                    $newQuery->where('amount', 'LIKE', '%' . $term . '%')
                        ->orWhereHas('cashbookAccount', function ($newQuery) use ($term) {
                            $newQuery->where('account_number', 'LIKE', '%' . $term . '%');
                        });
                });
        });

        // return IncomeResource::collection($query->latest()->paginate($request->perPage));
    }
}
