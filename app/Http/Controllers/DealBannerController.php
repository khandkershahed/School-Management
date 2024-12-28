<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DealBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DealBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['banners'] = DealBanner::latest('id')->get();
        return view('admin.pages.dealBanner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->buildCategories(Category::active()->get());
        $categoriesOptions = $this->buildCategoriesOptions($categories);
        $data = [
            'products'          => DB::table('products')->select('id', 'name')->latest('id')->get(),
            'brands'     => DB::table('brands')->select('id', 'name')->latest('id')->get(),
            'categoriesOptions' => $categoriesOptions,
        ];
        return view('admin.pages.dealBanner.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_name'   => 'nullable',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'bg_image'    => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'badge'       => 'nullable|string|max:191',
            'button_name' => 'nullable|string|max:200',
            'button_link' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ], [
            'image.file'                => 'The Image must be a file.',
            'image.mimes'               => 'The Image must be a file of type: jpeg, png, jpg, gif.',
            'image.max'                 => 'The Image may not be greater than 2MB.',
            'bg_image.file'             => 'The Image must be a file.',
            'bg_image.mimes'            => 'The Image must be a file of type: jpeg, png, jpg, gif.',
            'bg_image.max'              => 'The Image may not be greater than 2MB.',
            'status.required'           => 'The Status field is required.',
            'status.in'                 => 'The status must be one of: active, inactive.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();

        try {
            $files = [
                'image' => $request->file('image'),
                'bg_image' => $request->file('bg_image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'dealbanner/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            DealBanner::create([
                'image'       => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
                'bg_image'    => $uploadedFiles['bg_image']['status'] == 1 ? $uploadedFiles['bg_image']['file_path'] : null,
                'product_id'  => $request->product_id,
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_id,
                'badge'       => $request->badge,
                'price'       => $request->price,
                'offer_price' => $request->offer_price,
                'page_name'   => $request->page_name,
                'title'       => $request->title,
                'slug'        => $request->slug,
                'subtitle'    => $request->subtitle,
                'button_name' => $request->button_name,
                'button_link' => $request->button_link,
                'banner_link' => $request->banner_link,
                'status'      => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.deal-banner.index')->with('success', 'Banner created successfully');
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
            'banner'     => DealBanner::findOrFail($id),
            'products'   => DB::table('products')->select('id', 'name')->latest('id')->get(),
            'brands'     => DB::table('brands')->select('id', 'name')->latest('id')->get(),
            'categories' => DB::table('categories')->select('id', 'name')->latest('id')->get(),
        ];
        return view('admin.pages.dealBanner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = DealBanner::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'page_name'   => 'nullable',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'badge'       => 'nullable|string|max:191',
            'button_name' => 'nullable|string|max:200',
            'button_link' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ], [
            'image.file'                => 'The Image must be a file.',
            'image.mimes'               => 'The Image must be a file of type: jpeg, png, jpg, gif.',
            'image.max'                 => 'The Image may not be greater than 2MB.',
            'status.required'           => 'The Status field is required.',
            'status.in'                 => 'The status must be one of: active, inactive.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();

        try {
            $files = [
                'image' => $request->file('image'),
                'bg_image' => $request->file('bg_image'),
            ];
            $uploadedFiles = [];

            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'pagebanner/' . $key;
                    $oldFile = $banner->$key ?? null;

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



            $banner->update([
                'image'       => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $banner->image,
                'bg_image'    => $uploadedFiles['bg_image']['status'] == 1 ? $uploadedFiles['bg_image']['file_path'] : $banner->bg_image,
                'product_id'  => $request->product_id,
                'category_id' => $request->category_id,
                'brand_id'    => $request->brand_id,
                'badge'       => $request->badge,
                'price'       => $request->price,
                'offer_price' => $request->offer_price,
                'page_name'   => $request->page_name,
                'title'       => $request->title,
                'slug'        => $request->slug,
                'subtitle'    => $request->subtitle,
                'button_name' => $request->button_name,
                'button_link' => $request->button_link,
                'banner_link' => $request->banner_link,
                'status'      => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.deal-banner.index')->with('success', 'Banner updated successfully');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an error
            DB::rollback();

            // Return back with error message
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the Brand: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = DealBanner::findOrFail($id);
        $files = [
            'image'    => $banner->image,
            'bg_image' => $banner->bg_image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $banner->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $banner->delete();
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
