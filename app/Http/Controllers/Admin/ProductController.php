<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'products'     => DB::table('products')->where('status', 'published')->latest('id')->get(),
        ];
        return view('admin.pages.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->buildCategories(Category::active()->get());
        $categoriesOptions = $this->buildCategoriesOptions($categories);
        $data = [
            'brands'            => DB::table('brands')->select('id', 'name')->latest('id')->get(),
            'categoriesOptions' => $categoriesOptions,
        ];
        return view('admin.pages.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        $thumbnailFile = $request->file('thumbnail');
        $thumbnailFilePath = null;
        try {
            // Handle the file upload for the thumbnail



            if ($thumbnailFile) {
                $thumbnailUpload = customUpload($thumbnailFile, 'products/thumbnail');
                if ($thumbnailUpload['status'] === 0) {
                    return redirect()->back()->with('error', $thumbnailUpload['error_message']);
                }
                $thumbnailFilePath = $thumbnailUpload['file_path'];
            }

            $is_refurbished = $request->has('is_refurbished') ? 1 : 0;

            // dd($is_refurbished);
            // Create a new product record
            $product = Product::create([
                'name'                      => $request->input('name'),
                'sku_code'                  => $request->input('sku_code'),
                'mf_code'                   => $request->input('mf_code'),
                'product_code'              => $request->input('barcode_id'),
                'barcode_id'                => $request->input('barcode_id'),
                'tags'                      => $request->input('tags'),
                'color'                     => $request->input('color'),
                'short_description'         => $request->input('short_description'),
                'overview'                  => $request->input('overview'),
                'description'               => $request->input('description'),
                'specification'             => $request->input('specification'),
                'warranty'                  => $request->input('warranty'),
                'thumbnail'                 => $thumbnailFilePath,
                'box_stock'                 => $request->input('box_stock', 1),
                'stock'                     => $request->input('stock'),
                'box_contains'              => $request->input('box_contains'),
                'box_price'                 => $request->input('box_price'),
                'box_discount_price'        => $request->input('box_discount_price'),
                'unit_price'                => $request->input('unit_price'),
                'unit_discount_price'       => $request->input('unit_discount_price'),
                'is_refurbished'            => $is_refurbished,
                'product_type'              => $request->input('product_type'),
                'category_id'               => $request->input('category_id'),
                'vat'                       => $request->input('vat'),
                'tax'                       => $request->input('tax'),
                'length'                    => $request->input('length'),
                'width'                     => $request->input('width'),
                'height'                    => $request->input('height'),
                'brand_id'                  => $request->input('brand_id'),
                'create_date'               => Carbon::now(),
                'meta_title'                => $request->input('meta_title'),
                'meta_description'          => $request->input('meta_description'),
                'meta_keywords'             => $request->input('meta_keywords'),
                'added_by'                  => Auth::guard('admin')->user()->id,
                'status'                    => $request->input('status'),
            ]);

            // Handle multiple image uploads
            if ($request->hasFile('multi_images')) {
                foreach ($request->file('multi_images') as $image) {
                    if ($image) {
                        $multiImageUpload = customUpload($image, 'products/multi_images');
                        if ($multiImageUpload['status'] === 0) {
                            return redirect()->back()->with('error', $multiImageUpload['error_message']);
                        }
                        ProductImage::create([
                            'product_id' => $product->id,
                            'photo'      => $multiImageUpload['file_path'],
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }
            }

            DB::commit();

            // Redirect with success message
            return redirect()->route('admin.product.index')->with('success', 'Product has been created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            if ($thumbnailFilePath) {
                Storage::delete("public/" . $thumbnailFilePath);
            }
            // Redirect with error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the product: ' . $e->getMessage());
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
            'product'    => Product::findOrFail($id),
            'brands'     => DB::table('brands')->select('id', 'name')->latest('id')->get(),
            'categories' => DB::table('categories')->select('id', 'name')->latest('id')->get(),
        ];
        // dd($data['product']);
        return view('admin.pages.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
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
                'sku_code'                  => $request->input('sku_code'),
                'mf_code'                   => $request->input('mf_code'),
                'product_code'              => $request->input('barcode_id'),
                'barcode_id'                => $request->input('barcode_id'),
                'tags'                      => $request->input('tags'),
                'color'                     => $request->input('color'),
                'short_description'         => $request->input('short_description'),
                'overview'                  => $request->input('overview'),
                'description'               => $request->input('description'),
                'specification'             => $request->input('specification'),
                'warranty'                  => $request->input('warranty'),
                'thumbnail'                 => $thumbnailFilePath,
                'box_stock'                 => $request->input('box_stock', 1),
                'stock'                     => $request->input('stock'),
                'box_contains'              => $request->input('box_contains'),
                'box_price'                 => $request->input('box_price'),
                'box_discount_price'        => $request->input('box_discount_price'),
                'unit_price'                => $request->input('unit_price'),
                'unit_discount_price'       => $request->input('unit_discount_price'),
                'is_refurbished'            => $is_refurbished,
                'product_type'              => $request->input('product_type'),
                'category_id'               => $request->input('category_id'),
                'vat'                       => $request->input('vat'),
                'tax'                       => $request->input('tax'),
                'length'                    => $request->input('length'),
                'width'                     => $request->input('width'),
                'height'                    => $request->input('height'),
                'brand_id'                  => $request->input('brand_id'),
                'create_date'               => $product->create_date,
                'meta_title'                => $request->input('meta_title'),
                'meta_description'          => $request->input('meta_description'),
                'meta_keywords'             => $request->input('meta_keywords'),
                // 'added_by'                  => Auth::guard('admin')->user()->id,
                'status'                    => $request->input('status'),
            ]);

            // Handle multiple image uploads
            if ($request->hasFile('multi_img')) {
                foreach ($request->file('multi_img') as $image) {
                    if ($image) {
                        $multiImageUpload = customUpload($image, 'products/multi_images');
                        if ($multiImageUpload['status'] === 0) {
                            return redirect()->back()->with('error', $multiImageUpload['error_message']);
                        }
                        ProductImage::create([
                            'product_id' => $product->id,
                            'photo'      => $multiImageUpload['file_path'],
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }
            }

            // Handle deletion of removed images
            if ($request->input('remove_images')) {
                $imagesToRemove = json_decode($request->input('remove_images'), true);
                foreach ($imagesToRemove as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        if ($image->photo && Storage::exists("public/" . $image->photo)) {
                            Storage::delete("public/" . $image->photo);
                        }
                        $image->delete();
                    }
                }
            }

            DB::commit();

            // Redirect with success message
            return redirect()->back()->with('success', 'Product has been updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            // Redirect with error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::with('multiImages')->findOrFail($id);

        // Delete the product's thumbnail image if it exists
        if ($product->thumbnail) {
            Storage::delete("public/" . $product->thumbnail);
        }

        // Delete the product
        $product->delete();

        // Delete all associated multi-images
        $images = $product->multiImages;
        foreach ($images as $img) {
            if ($img->photo) {
                Storage::delete("public/" . $img->photo);
            }
            $img->delete();
        }
    }
    public function multiImageDestroy(string $id)
    {
        $multiImage = ProductImage::findOrFail($id);
        $files = [
            'photo' => $multiImage->photo,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $multiImage->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $multiImage->delete();
    }

    private function buildCategories($categories, $parentId = null)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $children = $this->buildCategories($categories, $category->id);

                if ($children) {
                    $category->children = $children;
                }

                $result[] = $category;
            }
        }

        return $result;
    }

    private function buildCategoriesOptions($selectedId = null, $excludeId = null, $parentId = null, $prefix = '')
    {
        $categories = Category::active()->where('parent_id', $parentId)->where('id', '!=', $excludeId)->get();
        $options = '';

        foreach ($categories as $category) {
            $selected = $category->id == $selectedId ? 'selected' : '';
            $options .= '<option value="' . $category->id . '" ' . $selected . '>' . $prefix . $category->name . '</option>';
            $options .= $this->buildCategoriesOptions($selectedId, $excludeId, $category->id, $prefix . '--');
        }

        return $options;
    }
}
