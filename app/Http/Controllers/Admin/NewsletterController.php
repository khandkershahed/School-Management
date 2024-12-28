<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.subscribedEmail.index',['emails' => Newsletter::get()]);
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'unique' => 'This email has already been subscribed.',
            'required' => 'The :attribute field is required.',
            'email' => 'Please provide a valid email address.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                flash()->addError($error, 'Failed', ['timeOut' => 30000]);
            }
            return redirect()->back()->withInput();
        }

        Newsletter::create([
            'email'              => $request->email,
            'ip_address'         => $request->ip(),
            'location'           => $request->location ?? null,
            'country'            => $request->country ?? null,
            'status'             => 'subscribed',
            'is_banned'          => '0',
            'promotional_email'  => '1',
            'newsletter'         => '1',
            'new_product'        => '1',
            'notification_email' => '1',
            'created_at'         => now(),
        ]);

        return redirect()->back()->with('success', 'You have subscribed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Newsletter $newsletter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        $newsletter->update([
            'email'              => $request->email,
            'ip_address'         => $request->ip(),
            'location'           => $request->location ?? $newsletter->location,
            'country'            => $request->country ?? $newsletter->country,
            'status'             => $request->status ?? $newsletter->status,
            'is_banned'          => $request->is_banned ?? $newsletter->is_banned,
            'promotional_email'  => $request->promotional_email ?? $newsletter->promotional_email,
            'newsletter'         => $request->newsletter ?? $newsletter->newsletter,
            'new_product'        => $request->new_product ?? $newsletter->new_product,
            'notification_email' => $request->notification_email ?? $newsletter->notification_email,
            'updated_at'         => now(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
    }
}
