<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fee;
use Illuminate\Http\Request;
use App\Models\EducationMedium;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'fees' => Fee::get(),
        ];

        return view("admin.pages.fees.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'mediums' => EducationMedium::get(),
        ];
        return view("admin.pages.fees.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|max:200',
                'class'     => 'required',
                'amount'    => 'required|min:1',
                'status'    => 'required|in:active,inactive',
                'medium'    => 'required|string',
            ], [
                'name.required'   => 'The name field is required.',
                'class.required'  => 'The class field is required.',
                'amount.required' => 'The amount field is required.',
                'medium.required' => 'The medium field is required.',
                'status.required' => 'The status field is required.',
                'name.string'     => 'The name must be a string.',
                'name.max'        => 'The name may not be greater than :max characters.',
                'name.unique'     => 'This name has already been taken.',
                'status.in'       => 'The status must be one of: active, inactive.',
            ]);

            if ($validator->fails()) {
                // foreach ($validator->messages()->all() as $message) {
                //     Session::flash('error', $message);
                // }
                Session::flash('error', $validator->messages()->all());
                return redirect()->back()->withInput();
            }
            // create client
            $fee = Fee::create([
                'name'        => $request->name,
                'class'       => json_encode($request->class),
                'description' => $request->description,
                'amount'      => $request->amount,
                'status'      => $request->status,
                'medium'      => $request->medium,
                'medium_id'   => $request->medium_id,
            ]);

            //send welcome notification

            redirectWithSuccess('fee added successfully');
            return redirect()->route('admin.fees.index');
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
            'fee'     => Fee::findOrFail($id),
        ];
        return view("admin.pages.fees.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $fee =  Fee::findOrFail($id);
            // create client
            $fee->update([
                'name'        => $request->name,
                'class'       => json_encode($request->class),
                'description' => $request->description,
                'amount'      => $request->amount,
                'status'      => $request->status,
                'medium'      => $request->medium,
                'medium_id'   => $request->medium_id,
            ]);

            //send welcome notification

            redirectWithSuccess('fee updated successfully');
            return redirect()->route('admin.fees.index');
        } catch (Exception $e) {
            redirectWithError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fee =  Fee::findOrFail($id);
        $fee->delete();
    }
}
