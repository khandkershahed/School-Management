<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'catalogues' => Catalogue::latest('id')->get(),
            'products'   => DB::table('products')->select('id', 'name')->latest('id')->get(),
            'brands'     => DB::table('brands')->select('id', 'name')->latest('id')->get(),
            'categories' => DB::table('categories')->select('id', 'name')->latest('id')->get(),
        ];
        return view('admin.pages.catalogue.index', $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Start the database transaction
        DB::beginTransaction();

        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'product_id' => 'array',
                'category_id' => 'array',
                'brand_id' => 'array',
                'title' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                // 'image' => 'nullable|image|mimes:jpeg,png,jpg',
                // 'attachment' => 'nullable|file|mimes:pdf,doc,docx',
                'url' => 'nullable|url',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle file uploads
            $files = [
                'image' => $request->file('image'),
                'attachment' => $request->file('attachment'),
            ];
            $uploadedFiles = [];

            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'catalogues/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);

                    // Debugging output
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Create the Catalogue model instance
            $catalogue = Catalogue::create([
                'product_id'  => json_encode($request->product_id),
                'category_id' => json_encode($request->category_id),
                'brand_id'    => json_encode($request->brand_id),
                'title'       => $request->title,
                'status'      => $request->status,
                'image'       => $uploadedFiles['image']['status'] === 1 ? $uploadedFiles['image']['file_path'] : null,
                'attachment'  => $uploadedFiles['attachment']['status'] === 1 ? $uploadedFiles['attachment']['file_path'] : null,
                'url'         => $request->url,
            ]);

            // Commit the database transaction
            DB::commit();

            return redirect()->back()->with('success', 'Catalogue created successfully.');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the catalogue: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Catalogue $catalogue)
    {
        DB::beginTransaction();

        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'product_id' => 'array',
                'category_id' => 'array',
                'brand_id' => 'array',
                'title' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                // 'image' => 'nullable|image|mimes:jpeg,png,jpg',
                // 'attachment' => 'nullable|file|mimes:pdf,doc,docx',
                'url' => 'nullable|url',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle file uploads
            $files = [
                'image' => $request->file('image'),
                'attachment' => $request->file('attachment'),
            ];
            $uploadedFiles = [];

            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'catalogues/' . $key;
                    $oldFile = $catalogue->$key ?? null;

                    if ($oldFile) {
                        Storage::delete($oldFile);
                    }

                    $uploadedFiles[$key] = customUpload($file, $filePath);

                    // Debugging output
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Update the catalogue with the new or existing file paths
            $catalogue->update([
                'product_id'  => json_encode($request->product_id),
                'category_id' => json_encode($request->category_id),
                'brand_id'    => json_encode($request->brand_id),
                'title'       => $request->title,
                'status'      => $request->status,
                'image'       => $uploadedFiles['image']['status'] === 1 ? $uploadedFiles['image']['file_path'] : $catalogue->image,
                'attachment'  => $uploadedFiles['attachment']['status'] === 1 ? $uploadedFiles['attachment']['file_path'] : $catalogue->attachment,
                'url'         => $request->url,
            ]);

            // Commit the database transaction
            DB::commit();

            return redirect()->back()->with('success', 'Catalogue updated successfully.');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating the catalogue: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalogue $catalogue)
    {
        //Delete the image if it exists
        $files = [
            'image' => $catalogue->image,
            'attachment' => $catalogue->attachment,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $catalogue->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $catalogue->delete();
    }
}
