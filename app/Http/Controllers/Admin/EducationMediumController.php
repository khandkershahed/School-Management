<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EducationMedium;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EducationMediumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.educationMedium.index', [
            'mediums' => EducationMedium::get()
        ]);
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
            'name'      => 'required|string|max:200|unique:education_media,name',
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
        try {

            EducationMedium::create([
                'name'   => $request->name,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            redirectWithSuccess('Education Medium Added Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medium = EducationMedium::where('id',$id)->first();
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:200|unique:education_media,name,' . $medium->id,
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
        try {

            $medium->update([
                'name'   => $request->name,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            redirectWithSuccess('Education Medium Updated Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medium = EducationMedium::where('id',$id)->first();
        $medium->delete();
    }
}
