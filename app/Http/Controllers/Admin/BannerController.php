<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * The function sets middleware permissions for specific actions in a PHP class constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:view banner')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.banner.index', ['banner' => Banner::get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function updateOrcreateBanner(BannerRequest $request)
    {
        $currentBanner = Banner::first();

        $dataToUpdateOrCreate = [
            'image'       => $request->image,
            'badge'       => $request->badge,
            'title'       => $request->title,
            'quote'       => $request->quote,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
        ];

        if ($request->hasFile('image')) {
            $siteLogoPath = handaleFileUpload($request->file('image'), 'banners');

            if ($siteLogoPath) {
                // check if there's an existing site logo and delete it
                if ($currentBanner && $currentBanner->image) {
                    $existingSiteLogo = storage_path('app/public/' . $currentBanner->image);
                    if (File::exists($existingSiteLogo)) {
                        File::delete($existingSiteLogo);
                    }
                }
                $dataToUpdateOrCreate['image'] = $siteLogoPath;
            }
        }

        $banner = Banner::updateOrCreate([], $dataToUpdateOrCreate);

        $toastrMessage = $banner->wasRecentlyCreated ? 'Banner created successfully' : 'Banner updated successfully';

        return redirect()->route('admin.banner.index')->with('success', $toastrMessage);
    }
}
