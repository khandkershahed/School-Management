<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fee;
use Illuminate\Http\Request;
use App\Models\EducationMedium;
use App\Http\Controllers\Controller;

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

            // create client
            $userSchema = Fee::create([
                'name'        => $request->name,
                'class'       => json_encode($request->class),
                'description' => $request->description,
                'amount'      => $request->amount,
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
            'mediums' => EducationMedium::get(),
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
        //
    }
}
