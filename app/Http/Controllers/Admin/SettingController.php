<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\SettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.setting.index', ['setting' => Setting::first()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function updateOrcreateSetting(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                // General Settings
                'site_name' => 'nullable|string|max:250', // Max length for site name
                'site_motto' => 'nullable|string', // No specific length, just ensuring it's a string
                'site_url' => 'nullable|url', // URL validation for the site URL
                'address_line_one' => 'nullable|string',
                'address_line_two' => 'nullable|string',
                'default_language' => 'nullable|string|max:50', // Assuming 50 characters for language
                'default_currency' => 'nullable|string|max:100',
                'currency_symbol' => 'nullable|string|max:10',
                'date_format' => 'nullable|string|max:50', // Example format: 'Y-m-d'
                'time_format' => 'nullable|string|max:50', // Example format: 'H:i'

                // Social Media URLs
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'linkedin_url' => 'nullable|url',
                'youtube_url' => 'nullable|url',
                'github_url' => 'nullable|url',
                'portfolio_url' => 'nullable|url',
                'fiverr_url' => 'nullable|url',
                'upwork_url' => 'nullable|url',

                // Logo & Favicon
                'site_white_logo' => 'nullable|string|max:255', // File path or URL
                'site_black_logo' => 'nullable|string|max:255', // File path or URL
                'site_favicon' => 'nullable|string|max:255', // File path or URL

                // Contact Information
                'contact_email' => 'nullable|email|max:100',
                'support_email' => 'nullable|email|max:100',
                'info_email' => 'nullable|email|max:100',
                'sales_email' => 'nullable|email|max:100',
                'phone_one' => 'nullable|string|max:20', // Adjust length for phone numbers
                'phone_two' => 'nullable|string|max:20',
                'whatsapp_number' => 'nullable|string|max:20',
                'contact_hours' => 'nullable|string|max:255', // E.g., "Mon-Fri, 9 AM - 5 PM"

                // Maintenance Mode
                'maintenance_mode' => 'nullable|boolean', // It should be either true or false
                'system_timezone' => 'nullable|string|max:200', // E.g., 'UTC', 'EST'
                'maintenance_message' => 'nullable|string',
                'additional_script' => 'nullable|string',
                'google_adsense' => 'nullable|string',
                'google_tag_manager' => 'nullable|string',
                'google_script' => 'nullable|string',
                'google_business' => 'nullable|string',

                // SEO Settings
                'seo_title' => 'nullable|string|max:255',
                'seo_keywords' => 'nullable|string|max:255',
                'seo_meta_tags' => 'nullable|string',
                'seo_description' => 'nullable|string',
                'og_image' => 'nullable|string|max:255', // URL or file path
                'og_title' => 'nullable|string|max:255',
                'og_description' => 'nullable|string',
                'canonical_url' => 'nullable|url',

                // Advanced Settings
                'theme_color' => 'nullable|string|max:50',
                'dark_mode' => 'nullable|boolean',
                'custom_css' => 'nullable|string',
                'custom_js' => 'nullable|string',

                // API Integration
                'map_api_key' => 'nullable|string',
                'payment_gateway_key' => 'nullable|string',

                // Business Information
                'company_name' => 'nullable|string|max:255',
                'tax_number' => 'nullable|string|max:100',
                'billing_address' => 'nullable|string',

                // Service Info
                'service_days' => 'nullable|string|max:255',
                'service_time' => 'nullable|string|max:255',

                // Meta Fields
                'created_by' => 'nullable|exists:users,id', // Ensure created_by refers to a valid user ID
                'updated_by' => 'nullable|exists:users,id', // Ensure updated_by refers to a valid user ID

                // Timestamps (These can usually be skipped in validation, Laravel will handle them)
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                // Flash error messages to session
                Session::flash('error', $validator->errors()->all());

                // Redirect back with errors and old input
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $webSetting = Setting::firstOrNew([]);

            $files = [
                'og_image'        => $request->file('og_image'),
                'site_white_logo' => $request->file('site_white_logo'),
                'site_black_logo' => $request->file('site_black_logo'),
                'site_favicon'    => $request->file('site_favicon'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'webSetting/' . $key;
                    $oldFile = $webSetting->$key ?? null;

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

            $setting = Setting::updateOrCreate([], [
                'og_image'        => $uploadedFiles['og_image']['status']        == 1 ? $uploadedFiles['og_image']['file_path']   : $webSetting->og_image,
                'site_white_logo' => $uploadedFiles['site_white_logo']['status'] == 1 ? $uploadedFiles['site_white_logo']['file_path'] : $webSetting->site_white_logo,
                'site_black_logo' => $uploadedFiles['site_black_logo']['status'] == 1 ? $uploadedFiles['site_black_logo']['file_path'] : $webSetting->site_black_logo,
                'site_favicon'    => $uploadedFiles['site_favicon']['status'] == 1 ? $uploadedFiles['site_favicon']['file_path'] : $webSetting->site_favicon,

                // General Settings
                'site_name'          => $request->site_name,
                'site_motto'         => $request->site_motto,
                'site_url'           => $request->site_url,
                'address_line_one'   => $request->address_line_one,
                'address_line_two'   => $request->address_line_two,
                'default_language'   => $request->default_language,
                'default_currency'   => $request->default_currency,
                'currency_symbol'    => $request->currency_symbol,
                'date_format'        => $request->date_format,
                'time_format'        => $request->time_format,



                // Contact Information
                'contact_email'      => $request->contact_email,
                'support_email'      => $request->support_email,
                'info_email'         => $request->info_email,
                'sales_email'        => $request->sales_email,
                'phone_one'          => $request->phone_one,
                'phone_two'          => $request->phone_two,
                'whatsapp_number'    => $request->whatsapp_number,
                'contact_hours'      => $request->contact_hours,

                // Maintenance Mode
                'maintenance_mode'   => $request->maintenance_mode,
                'system_timezone'    => $request->system_timezone,
                'maintenance_message' => $request->maintenance_message,
                'additional_script'  => $request->additional_script,
                'google_adsense'     => $request->google_adsense,
                'google_tag_manager' => $request->google_tag_manager,
                'google_script'      => $request->google_script,
                'google_business'    => $request->google_business,

                // SEO Settings
                'seo_title'          => $request->seo_title,
                'seo_keywords'       => $request->seo_keywords,
                'seo_meta_tags'      => $request->seo_meta_tags,
                'seo_description'    => $request->seo_description,
                'og_title'           => $request->og_title,
                'og_description'     => $request->og_description,
                'canonical_url'      => $request->canonical_url,

                // Social Media
                'facebook_url'       => $request->facebook_url,
                'twitter_url'        => $request->twitter_url,
                'instagram_url'      => $request->instagram_url,
                'linkedin_url'       => $request->linkedin_url,
                'youtube_url'        => $request->youtube_url,
                'github_url'         => $request->github_url,
                'portfolio_url'      => $request->portfolio_url,
                'fiverr_url'         => $request->fiverr_url,
                'upwork_url'         => $request->upwork_url,

                // Advanced Settings
                'theme_color'        => $request->theme_color,
                'dark_mode'          => $request->dark_mode,
                'custom_css'         => $request->custom_css,
                'custom_js'          => $request->custom_js,

                // API Integration
                'map_api_key'        => $request->map_api_key,
                'payment_gateway_key' => $request->payment_gateway_key,

                // Business Information
                'company_name'       => $request->company_name,
                'tax_number'         => $request->tax_number,
                'billing_address'    => $request->billing_address,

                // Service Info
                'service_days'       => $request->service_days,
                'service_time'       => $request->service_time,

                // Meta Fields
                'created_by'         => Auth::guard('admin')->user()->id,
                'updated_by'         => Auth::guard('admin')->user()->id,
            ]);







            // $setting = Setting::updateOrCreate([], $dataToUpdateOrCreate);

            $toastrMessage = $setting->wasRecentlyCreated ? 'Setting created successfully' : 'Setting updated successfully';

            return redirect()->back()->with('success', $toastrMessage);
        } catch (\Exception $e) {
            Session::flash('error', [$messages = $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', [$messages = $e->getMessage()]);
        }
    }
}
