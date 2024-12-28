<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\BrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = Brand::latest('id')->get();
        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $editUrl   = route('admin.brands.edit', $row->id);
        //             $deleteUrl = route('admin.brands.destroy', $row->id);

        //             $html = <<<HTML
        //             <td class="text-end">
        //                 <a href="{$editUrl}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
        //                     <span class="svg-icon svg-icon-3">
        //                         <i class="fas fa-pen"></i>
        //                     </span>
        //                 </a>
        //                 <a href="{$deleteUrl}" class="btn btn-icon btn-active-light-danger w-30px h-30px delete">
        //                     <span class="svg-icon svg-icon-3">
        //                         <i class="fas fa-trash-alt"></i>
        //                     </span>
        //                 </a>
        //             </td>
        //             HTML;

        //             return new HtmlString($html);
        //         })->rawColumns(['action'])->make(true);
        // }
        $data =[
            'brands' => Brand::latest('id')->get(),
        ];
        return view('admin.pages.brands.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        // Start the database transaction
        DB::beginTransaction();

        try {
            $files = [
                'logo' => $request->file('logo'),
                'image' => $request->file('image'),
                'banner_image' => $request->file('banner_image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'brands/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }
            // Create the Brand model instance
            $brand = Brand::create([
                'name'         => $request->name,
                'logo'         => $uploadedFiles['logo']['status']         == 1 ? $uploadedFiles['logo']['file_path']        : null,
                'image'        => $uploadedFiles['image']['status']        == 1 ? $uploadedFiles['image']['file_path']       : null,
                'banner_image' => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : null,
                'description'  => $request->description,
                'url'          => $request->url,
                'status'       => $request->status,
            ]);

            // Commit the database transaction
            DB::commit();

            return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollback();

            // Return back with error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the Brand: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('admin.pages.brands.show', ['brand' => $brand]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.pages.brands.edit', ['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        DB::beginTransaction();

        try {
            $files = [
                'logo' => $request->file('logo'),
                'image' => $request->file('image'),
                'banner_image' => $request->file('banner_image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'brands/' . $key;
                    $oldFile = $brand->$key ?? null;

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

            // Update the brand with the new or existing file paths
            $brand->update([
                'name'         => $request->name,
                'logo'         => $uploadedFiles['logo']['status']         == 1 ? $uploadedFiles['logo']['file_path']        : $brand->logo,
                'image'        => $uploadedFiles['image']['status']        == 1 ? $uploadedFiles['image']['file_path']       : $brand->image,
                'banner_image' => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : $brand->banner_image,
                'description'  => $request->description,
                'url'          => $request->url,
                'status'       => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating the brand: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //Delete the image if it exists
        $files = [
            'logo' => $brand->logo,
            'image' => $brand->image,
            'banner_image' => $brand->banner_image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $brand->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $brand->delete();
    }

    public function toggleStatus(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = $brand->status == 'active' ? 'inactive' : 'active';
        $brand->save();
        return response()->json(['success' => true]);
    }
}
