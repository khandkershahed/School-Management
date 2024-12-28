<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:150|unique:faq_categories,name',
            'status'    => 'required|in:active,inactive',
        ], [
            'name.required'   => 'The name field is required.',
            'name.string'     => 'The name must be a string.',
            'name.max'        => 'The name may not be greater than :max characters.',
            'name.unique'     => 'This name has already been taken.',
            'status.required' => 'The Status field is required.',
            'status.in'       => 'The status must be one of: active, inactive.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }

        FaqCategory::create([
            'name'      => $request->name,
            'status'    => $request->status,
        ]);
        // toastr()->success('Data has been saved successfully!');
        return redirect()->back()->with('success', 'Data has been saved successfully!');
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

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:150',
            'status'    => 'required|in:active,inactive',
        ], [
            'name.required'   => 'The name field is required.',
            'name.string'     => 'The name must be a string.',
            'name.max'        => 'The name may not be greater than :max characters.',
            'status.required' => 'The Status field is required.',
            'status.in'       => 'The status must be one of: active, inactive.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }

        FaqCategory::find($id)->update([
            'name'      => $request->name,
            'status'    => $request->status,
        ]);
        // toastr()->success('Data has been saved successfully!');
        return redirect()->back()->with('success', 'Data has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        FaqCategory::find($id)->delete();
    }
}
