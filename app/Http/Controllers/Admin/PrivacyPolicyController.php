<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.privacyPolicy.index', ['policys' => PrivacyPolicy::latest('id')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.privacyPolicy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'           => 'required|string|max:250',
                'content'         => 'required',
                'effective_date'  => 'required',
                'expiration_date' => 'required',
            ],
            [
                'title.required'           => 'Title is required',
                'content.required'         => 'Content is required',
                'effective_date.required'  => 'Effective Date is required',
                'expiration_date.required' => 'Effective Date is required',
            ]
        );
        // dd($validator->fails());
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }
        DB::beginTransaction();

        try {
            $policy = PrivacyPolicy::create([
                'title'           => $request->title,
                'content'         => $request->content,
                'version'         => $request->version,
                'effective_date'  => $request->effective_date,
                'expiration_date' => $request->expiration_date,
                'status'          => $request->status ?? 'active',
            ]);

            // Commit the database transaction
            DB::commit();

            return redirect()->route('admin.privacy-policy.index')->with('success', 'Data Added successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the Privacy Policy: ' . $e->getMessage());
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
        $policy = PrivacyPolicy::findOrFail($id);
        return view('admin.pages.privacyPolicy.edit',  ['policy' => $policy]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        $validator = Validator::make(
            $request->all(),
            [
                'title'           => 'required|string|max:250',
                'content'         => 'required',
                'effective_date'  => 'required',
                'expiration_date' => 'required',
            ],
            [
                'title.required'           => 'Title is required',
                'content.required'         => 'Content is required',
                'effective_date.required'  => 'Effective Date is required',
                'expiration_date.required' => 'Effective Date is required',
            ]
        );
        // dd($validator->fails());
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }
        DB::beginTransaction();

        try {
            $policy->update([
                'title'           => $request->title,
                'content'         => $request->content,
                'version'         => $request->version,
                'effective_date'  => $request->effective_date,
                'expiration_date' => $request->expiration_date,
                'status'          => $request->status ?? $policy->status,
            ]);

            // Commit the database transaction
            DB::commit();

            return redirect()->route('admin.privacy-policy.index')->with('success', 'Data Updated successfully');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withInput()->with('error', 'An error occurred while Updating the Privacy Policy: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PrivacyPolicy::findOrFail($id)->delete();
    }
}
