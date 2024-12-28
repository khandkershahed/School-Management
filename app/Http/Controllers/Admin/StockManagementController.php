<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StockManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'products'     => DB::table('products')->where('status', 'published')->latest('id')->get(),
        ];
       return view('admin.pages.stockManagement.index',$data);
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
        //
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

    public function stockUpdate(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            // Find the existing product
            $product = Product::findOrFail($id);

            // Handle the file upload for the thumbnail
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailFilePath = $product->thumbnail; // Retain old thumbnail path if no new file

            if ($thumbnailFile) {
                // Delete old thumbnail file if exists
                if ($thumbnailFilePath && Storage::exists("public/" . $thumbnailFilePath)) {
                    Storage::delete("public/" . $thumbnailFilePath);
                }

                $thumbnailUpload = customUpload($thumbnailFile, 'products/thumbnail');
                if ($thumbnailUpload['status'] === 0) {
                    return redirect()->back()->with('error', $thumbnailUpload['error_message']);
                }
                $thumbnailFilePath = $thumbnailUpload['file_path'];
            }
            $is_refurbished = $request->has('is_refurbished') ? 1 : 0;
            // Update the product record
            $product->update([
                'name'                      => $request->input('name'),
                'box_stock'                 => $request->input('box_stock', 1),
                'stock'                     => $request->input('stock'),
                'thumbnail'                 => $thumbnailFilePath,
                // 'box_contains'              => $request->input('box_contains'),
                // 'box_price'                 => $request->input('box_price'),
                // 'box_discount_price'        => $request->input('box_discount_price'),
                // 'unit_price'                => $request->input('unit_price'),
                // 'unit_discount_price'       => $request->input('unit_discount_price'),
                'updated_at'                => Carbon::now(),
            ]);



            DB::commit();

            // Redirect with success message
            return redirect()->back()->with('success', 'Product Stock has been updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            // Redirect with error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the Product Stock: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
