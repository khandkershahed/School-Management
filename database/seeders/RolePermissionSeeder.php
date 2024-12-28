<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'group_name' => 'Role',
                'permissions' => [
                    'view role',
                    'edit role',
                    'delete role',
                    'create role',
                    'give permission role',
                    'store permission role',
                ],
            ],
            [
                'group_name' => 'Permission',
                'permissions' => [
                    'view permission',
                    'edit permission',
                    'delete permission',
                    'create permission',
                ],
            ],
            [
                'group_name' => 'Email Settings',
                'permissions' => [
                    'view email settings',
                    'create email settings',
                    'edit email settings',
                    'delete email settings',
                    'toggle status email settings',
                ],
            ],
            [
                'group_name' => 'User',
                'permissions' => [
                    'view user',
                    'create user',
                    'show user',
                    'edit user',
                    'delete user',
                ],
            ],
            [
                'group_name' => 'Staff',
                'permissions' => [
                    'view staff',
                    'create staff',
                    'show staff',
                    'edit staff',
                    'delete staff',
                ],
            ],
            [
                'group_name' => 'Categories',
                'permissions' => [
                    'view categories',
                    'show categories',
                    'edit categories',
                    'delete categories',
                    'create categories',
                ],
            ],
            [
                'group_name' => 'Backup',
                'permissions' => [
                    'download backup',
                ],
            ],
            [
                'group_name' => 'Log',
                'permissions' => [
                    'view log',
                    'show log',
                    'delete log',
                    'download log',
                ],
            ],
            [
                'group_name' => 'Activity Logs',
                'permissions' => [
                    'view activity logs',
                    'show activity logs',
                    'delete activity logs',
                ],
            ],
            [
                'group_name' => 'Tags',
                'permissions' => [
                    'view tag',
                    'show tag',
                    'edit tag',
                    'delete tag',
                    'create tag',
                ],
            ],
            [
                'group_name' => 'Banners',
                'permissions' => [
                    'view banner',
                ],
            ],

        ];

        $roleAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);

        foreach ($permissions as $permission) {

            $permissions = $permission['group_name'];
            foreach ($permission['permissions'] as $permissionName) {
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'group_name' => $permissions,
                    'guard_name' => 'admin',
                ]);
                $roleAdmin->givePermissionTo($permission);
            }
        }
        $admin = Admin::where('email', 'khandkershahed23@gmail.com')->first();
        if ($admin) {
            $admin->assignRole($roleAdmin);
        }
    }
}
