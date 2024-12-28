<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutUsRequest;
use Illuminate\Support\Facades\File;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.about-us.index', ['aboutUs' => AboutUs::first()]);
    }

    public function updateOrcreateAboutUs(AboutUsRequest $request)
    {
        DB::beginTransaction();

        try {
            $currentAboutUs = AboutUs::first();

            $dataToUpdateOrCreate = [
                'image'             => $request->image,
                'badge'             => $request->badge,
                'title'             => $request->title,
                'short_description' => $request->short_description,
                'button_name'       => $request->button_name,
                'button_link'       => $request->button_link,
            ];

            if ($request->hasFile('image')) {
                $siteLogoPath = handaleFileUpload($request->file('image'), 'aboutUs');

                if ($siteLogoPath) {
                    // check if there's an existing site logo and delete it
                    if ($currentAboutUs && $currentAboutUs->image) {
                        $existingSiteLogo = storage_path('app/public/' . $currentAboutUs->image);
                        if (File::exists($existingSiteLogo)) {
                            File::delete($existingSiteLogo);
                        }
                    }
                    $dataToUpdateOrCreate['image'] = $siteLogoPath;
                }
            }

            $aboutUs = AboutUs::updateOrCreate([], $dataToUpdateOrCreate);

            $toastrMessage = $aboutUs->wasRecentlyCreated ? 'AboutUs created successfully' : 'AboutUs updated successfully';

            DB::commit();

            return redirect()->route('admin.about-us.index')->with('success', $toastrMessage);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating or creating the AboutUs: ' . $e->getMessage());
        }
    }
}
