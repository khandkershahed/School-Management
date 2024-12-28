<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmployeeDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::latest('id')->get();
        return view('admin.pages.employeeDepartment.index', compact('departments'));

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
            'name'      => 'required|string|max:200|unique:departments,name',
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

            Department::create([
                'name'   => $request->name,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            redirectWithSuccess('Employee Department Added Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $department = Department::where('id',$id)->first();
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:200|unique:departments,name,' . $department->id,
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

            $department->update([
                'name'   => $request->name,
                'note'   => $request->note,
                'status' => $request->status,
            ]);
            redirectWithSuccess('Employee Department Updated Successfully');
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
        $department = Department::where('id',$id)->first();
        $department->delete();
    }
}
