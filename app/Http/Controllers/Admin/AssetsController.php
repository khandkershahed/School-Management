<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'assets' => Asset::with('assetType', 'user')->latest()->get(),
        ];
        return view('admin.pages.assets.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'asset_types' => AssetType::latest()->get(['id', 'name']),
        ];
        return view('admin.pages.assets.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
            'name'          => 'required|string|max:50|unique:assets,name',
            'assetType'     => 'required',
            'assetCost'     => 'required|numeric',
            'depreciation'  => 'required',
            'salvageValue'  => 'required|numeric|min:0|max:' . $request->assetCost,
            'usefulLife'    => $request->depreciation == 1 ? 'required|numeric|min:.1' : '',
            'note'          => 'nullable|string|max:255',
            'date'          => $request->depreciation == 1 ? 'required|date|after_or_equal:today' : 'required',
        ]);
        try {
            // upload thumbnail and set the name
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'assets/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // assign values
            $salvageValue = $request->salvageValue;
            $usefulLife = $request->usefulLife;
            if ($request->depreciation == 1 && $request->depreciationType == 'Month') {
                $depreciationType = 0;
                $duration = $request->usefulLife;
            } elseif ($request->depreciation == 1 && $request->depreciationType == 'Year') {
                $depreciationType = 1;
                $duration = $request->usefulLife * 12;
            } else {
                $depreciationType = $salvageValue = $usefulLife = $dailyDepreciation = $later = null;
            }

            // calculate daily depreciation
            if ($request->depreciation == 1) {
                $earlier = new DateTime($request->date);
                $later = Carbon::parse($earlier)->addMonths($duration);
                $abs_diff = $later->diff($earlier)->format('%a');
                $dailyDepreciation = $request->assetCost / $abs_diff;
            }

            // store asset
            Asset::create([
                'name'               => $request->name,
                'cat_id'             => $request->assetType,
                'asset_cost'         => $request->assetCost,
                'depreciation'       => $request->depreciation,
                'depreciation_type'  => $depreciationType,
                'salvage_value'      => $salvageValue,
                'useful_life'        => $usefulLife,
                'daily_depreciation' => $dailyDepreciation,
                'note'               => $request->note,
                'image_path'         => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
                'date'               => $request->date,
                'expire_date'        => $later,
                'created_by'         => Auth::guard('admin')->user()->id,
                'status'             => $request->status,
            ]);

            redirectWithSuccess('Asset added successfully');
            return redirect()->route('admin.assets.index');
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
            'asset'       => Asset::with('assetType', 'user')->where('slug', $id)->first(),
            'asset_types' => AssetType::latest()->get(['id', 'name']),
        ];
        return view('admin.pages.assets.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $asset = Asset::with('assetType')->where('id', $id)->first();
        // validate request
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:assets,name,' . $asset->id,
            'assetType' => 'required',
            'assetCost' => 'required|numeric',
            'depreciation' => 'required',
            'salvageValue' => 'nullable|numeric|min:0|max:' . $request->assetCost,
            'usefulLife' => $request->depreciation == 1 ? 'required|numeric|min:0' : '',
            'note' => 'nullable|string|max:255',
        ]);

        try {
            $assetType = $asset->assetType;
            // upload thumbnail and set the name
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'assets/' . $key;
                    $oldFile = $account->image_path ?? null;

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

            // assign values
            $salvageValue = $request->salvageValue;
            $usefulLife = $request->usefulLife;

            if ($request->depreciation == 1 && $request->depreciationType == 'Month') {
                $depreciationType = 0;
                $duration = $request->usefulLife;
            } elseif ($request->depreciation == 1 && $request->depreciationType == 'Year') {
                $depreciationType = 1;
                $duration = $request->usefulLife * 12;
            } else {
                $depreciationType = $salvageValue = $usefulLife = $dailyDepreciation = $later = null;
            }

            // calculate daily depreciation
            if ($request->depreciation == 1) {
                $earlier = new DateTime($request->date);
                $later = Carbon::parse($earlier)->addMonths($duration);
                $abs_diff = $later->diff($earlier)->format('%a');
                $dailyDepreciation = $request->assetCost / $abs_diff;
            }

            // update asset
            $asset->update([
                'name'               => $request->name,
                'cat_id'             => $assetType->id,
                'asset_cost'         => $request->assetCost,
                'depreciation'       => $request->depreciation,
                'depreciation_type'  => $depreciationType,
                'salvage_value'      => $salvageValue,
                'useful_life'        => $usefulLife,
                'daily_depreciation' => $dailyDepreciation,
                'expire_date'        => $later,
                'note'               => $request->note,
                'image_path'         => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $asset->image_path,
                'date'               => $request->date,
                'created_by'         => Auth::guard('admin')->user()->id,
                'status'             => $request->status,
            ]);

            redirectWithSuccess('Asset Updated successfully');
            return redirect()->route('admin.assets.index');
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
        $asset = Asset::with('assetType')->where('slug', $id)->first();
        $files = [
            'image_path' => $asset->image_path,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $asset->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $asset->delete();
    }
}
