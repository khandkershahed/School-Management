<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * The function sets middleware permissions for specific actions in a PHP class constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:view role|edit role|delete role|create role|give permission role|store permission role')->only(['index', 'create', 'edit', 'destroy', 'givePermission', 'storePermission']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.roles.index', ['roles' => Role::get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'permissionsByGroups' => Permission::select('group_name')
                ->distinct()
                ->orderBy('group_name')
                ->get(),

            'permissions' => Permission::orderBy('group_name')
                ->orderBy('name')
                ->get(),
        ];
        return view('admin.pages.roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name])->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Role created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // deprecated
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'role' => Role::findOrFail($id),
            'permissionsByGroups' => Permission::select('group_name')
                ->distinct()
                ->orderBy('group_name')
                ->get(),

            'permissions' => Permission::orderBy('group_name')
                ->orderBy('name')
                ->get(),
        ];
        return view('admin.pages.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Role deleted successfully');
    }

    public function givePermission(string $roleId)
    {
        return view('admin.pages.roles.give-permission', [
            'role' => Role::find($roleId),
            'permissions' => Permission::get()
        ]);
    }

    public function storePermission(Request $request, string $roleId)
    {
        $role = Role::find($roleId);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('sucess', 'Permissions assigned successfully');
    }
}
