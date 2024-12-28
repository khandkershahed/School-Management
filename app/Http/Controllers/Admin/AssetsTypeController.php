<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\AssetType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'asset_types' => AssetType::latest('id')->get(),
        ];
        return view('admin.pages.assets-type.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.assets-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
            'name' => 'required|string|max:150|unique:asset_types',
            'note' => 'nullable|string|max:255',
        ]);
        // save asset type
        try {

            AssetType::create([
                'name'   => $request->name,
                'note'   => $request->note,
                'status' => $request->status,
            ]);

            redirectWithSuccess('Asset Type created successfully');
            return redirect()->route('admin.assets-type.index');
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
            'asset_type' => AssetType::where('slug', $id)->first(),
        ];
        return view('admin.pages.assets-type.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assetType = AssetType::where('id', $id)->first();
        // validate request
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:asset_types,name,' . $assetType->id,
            'note' => 'nullable|string|max:255',
        ]);
        // save asset type
        try {

            $assetType->update([
                'name'   => $request->name,
                'note'   => $request->note,
                'status' => $request->status,
            ]);

            redirectWithSuccess('Asset Type updated successfully');
            return redirect()->route('admin.assets-type.index');
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
        $assetType = AssetType::where('slug', $id)->first();
        $assetType->delete();
    }
}
