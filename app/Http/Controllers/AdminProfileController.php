<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AdminProfileUpdateRequest;

class AdminProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => Auth::guard('admin')->user(),
            'roles' => Role::get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(AdminProfileUpdateRequest $request): RedirectResponse
    {


        $files = [
            'photo'    => $request->file('photo'),
        ];
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $filePath = 'admin/' . $key;
                $oldFile = $request->user()->$key ?? null;

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
        $request->user()->photo = $uploadedFiles['photo']['status'] == 1 ? $uploadedFiles['photo']['file_path'] : $request->user()->photo;
        $request->user()->fill($request->validated());
        // dd($request->user());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */

    public function destroy(Request $request)
    {
            // $request->validateWithBag('userDeletion', [
            //     'password' => ['required', 'current_password'],
            // ]);

        // Get the authenticated admin user
        $user = $request->user();

        Auth::guard('admin')->logout();

        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return Redirect::to('/');
        // return redirect('/');
    }
}
