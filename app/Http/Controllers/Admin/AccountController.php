<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'accounts' => Account::latest()->get(),
        ];
        return view("admin.pages.account.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.account.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'bank_name'      => 'required|string|max:100',
            'branch_name'    => 'nullable|string|max:100',
            'account_number' => 'required|string|max:100|unique:accounts,account_number',
            'date'           => 'nullable|date_format:Y-m-d',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max
            'note'           => 'nullable|string|max:255',
            'status'         => 'nullable|in:active,inactive',
        ]);

        try {
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'account/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Store account
            Account::create([
                'bank_name'      => $request->bank_name,
                'branch_name'    => $request->branch_name,
                'account_number' => $request->account_number,
                'image'          => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
                'date'           => $request->date,
                'created_by'     => Auth::guard('admin')->user()->id,
                'note'           => $request->note,
                'status'         => $request->status ?? 'active', // Default to 'active'
            ]);
            redirectWithSuccess('Account added successfully');
            return redirect()->route('admin.account.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data =[
            'account' => Account::where('slug',$id)->firstOrFail(),
        ];
        return view("admin.pages.account.edit",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $this->validate($request, [
            'bank_name'      => 'required|string|max:100',
            'branch_name'    => 'nullable|string|max:100',
            'account_number' => 'required|string|max:100|unique:accounts,account_number,' . $account->id,
            'date'           => 'nullable|date_format:Y-m-d',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'note'           => 'nullable|string|max:255',
            'status'         => 'nullable|in:active,inactive',
        ]);

        try {
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'account/' . $key;
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
            // Update account
            $account->update([
                'bank_name'      => $request->bank_name,
                'branch_name'    => $request->branch_name,
                'image'          => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $account->image,
                'account_number' => $request->account_number,
                'date'           => $request->date,
                'updated_by'     => Auth::guard('admin')->user()->id,
                'note'           => $request->note,
                'status'         => $request->status ?? 'active',
            ]);

            redirectWithSuccess('Account updated successfully');
            return redirect()->route('admin.account.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $files = [
            'image' => $account->image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $account->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $account->delete();
    }
}
