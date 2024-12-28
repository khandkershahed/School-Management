<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ShippingManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'shipping_methods' => ShippingMethod::latest('id')->get(),
        ];
        return view('admin.pages.shippingManagement.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new shipping method
        return view('admin.pages.shippingManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'location' => 'nullable|string|max:250',
            'duration' => 'nullable|string|max:250',
            'description' => 'nullable|string',
            'carrier' => 'nullable|string|max:250',
            'min_weight' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0|gte:min_weight',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
        ], [
            'max_weight.gte' => 'The maximum weight must be greater than or equal to the minimum weight.',
            'status.in' => 'The status must be either active or inactive.',
        ]);

        // Check for validation failures
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new shipping method
        ShippingMethod::create($request->only([
            'title', 'location', 'duration', 'description', 'carrier',
            'min_weight', 'max_weight', 'price', 'status'
        ]));

        // Redirect with success message
        return redirect()->back()->with('success', 'Shipping method has been created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $shippingMethod = ShippingMethod::findOrFail($id);
        return view('admin.pages.shippingManagement.edit', compact('shippingMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the shipping method or fail
        $shippingMethod = ShippingMethod::findOrFail($id);

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'location' => 'nullable|string|max:250',
            'duration' => 'nullable|string|max:250',
            'description' => 'nullable|string',
            'carrier' => 'nullable|string|max:250',
            'min_weight' => 'nullable|numeric|min:0',
            'max_weight' => 'nullable|numeric|min:0|gte:min_weight',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
        ], [
            'max_weight.gte' => 'The maximum weight must be greater than or equal to the minimum weight.',
            'status.in' => 'The status must be either active or inactive.',
        ]);

        // Check for validation failures
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the shipping method
        $shippingMethod->update($request->only([
            'title', 'location', 'duration', 'description', 'carrier',
            'min_weight', 'max_weight', 'price', 'status'
        ]));

        // Redirect with success message
        return redirect()->back()->with('success', 'Shipping method has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shippingMethod = ShippingMethod::findOrFail($id);
        $shippingMethod->delete();
    }
}
