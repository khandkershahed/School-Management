<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Events\ActivityLogged;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:view staff|create staff|show staff|edit staff|delete staff')->only(['index', 'create', 'show', 'edit', 'destroy']);
    }
    public function index()
    {
        return view('admin.pages.staff.index', ['staffs' => Admin::latest('id')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.staff.create', ['roles' => Role::get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Admin::class],
            'username' => ['string', 'max:191', 'unique:' . Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $files = [
            'photo'    => $request->file('photo'),
        ];
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $filePath = 'admin/' . $key;

                $uploadedFiles[$key] = customUpload($file, $filePath);
                if ($uploadedFiles[$key]['status'] === 0) {
                    return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                }
            } else {
                $uploadedFiles[$key] = ['status' => 0];
            }
        }

        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'designation' => $request->designation,
            'photo' => $uploadedFiles['photo']['status']    == 1 ? $uploadedFiles['photo']['file_path']   : null,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        event(new Registered($user));
        event(new ActivityLogged('User created', $user));

        return redirect()->route('admin.staff.index')->with('success', 'Staff Added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.pages.staff.show', [
            'user' => Admin::find($id),
            'roles' => Role::get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.pages.staff.edit', [
            'staff' => Admin::find($id),
            'roles' => Role::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $staff): RedirectResponse
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:' . Admin::class . ',email,' . $staff->id],
            'username' => ['string', 'max:191', 'unique:' . Admin::class . ',username,' . $staff->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $files = [
            'photo'    => $request->file('photo'),
        ];
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $filePath = 'admin/' . $key;
                $oldFile = $staff->$key ?? null;

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

        $staff->update([
            'name'        => $request->name ? $request->name  : $staff->name,
            'email'       => $request->email ? $request->email: $staff->email,
            'username'    => $request->username,
            'designation' => $request->designation,
            'photo'       => $uploadedFiles['photo']['status'] == 1 ? $uploadedFiles['photo']['file_path'] : $staff->photo,
            'password'    => $request->password ? Hash::make($request->password) : $staff->password,
        ]);

        if ($request->roles) {
            $staff->syncRoles($request->roles);
        }

        event(new ActivityLogged('Staff updated', $staff));

        return redirect()->route('admin.staff.index')->with('success', 'staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = Admin::findOrFail($id);
        $files = [
            'photo' => $staff->photo,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $staff->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $staff->delete();

        event(new ActivityLogged('Staff deleted', $staff));
    }
}
