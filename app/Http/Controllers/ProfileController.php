<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    public function profileUpdate(Request $request): RedirectResponse
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title'                         => 'nullable|in:Mr,Mrs,Ms',
            'first_name'                    => 'nullable|string|max:100',
            'last_name'                     => 'nullable|string|max:100',
            'email'                         => ['email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
            'phone'                         => 'nullable|max:20',
            'address_one'                   => 'nullable|string|max:255',
            'address_two'                   => 'nullable|string|max:255',
            'zipcode'                       => 'nullable|string|max:10',
            'state'                         => 'nullable|string|max:100',
            'company_name'                  => 'nullable|string|max:255',
            'company_registration_number'   => 'nullable|string|max:255',
            'company_vat_number'            => 'nullable|string|max:255',
            'selling_platforms'             => 'nullable|string',
            'customer_type'                 => 'nullable|string',
            'referral_source'               => 'nullable|string|max:255',
            'buying_group_membership'       => 'nullable|string|max:255',
            'website_address'               => 'nullable|url',
            'buying_group_name'             => 'nullable|string|max:255',
            'current_suppliers'             => 'nullable|string',
            'annual_spend'                  => 'nullable|string',
            'newsletter_preference'         => 'nullable',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fill user data with validated data
        $user = $request->user();
        $user->fill($validator->validated());

        // Handle email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save user changes
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        // $request->validateWithBag('userDeletion', [
        //     'password' => ['required', 'current_password'],
        // ]);

        // $user = $request->user();

        // Auth::logout();

        // $user->delete();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        // return Redirect::to('/');
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
