<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the first admin user
        Admin::factory()->create([
            'name'     => 'admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        Admin::factory()->create([
            'name'         => 'Shahed',
            'email'        => 'khandkershahed23@gmail.com',
            'password'     => Hash::make('password'),
            'account_role' => '0',

        ]);
        Admin::factory()->create([
            'name'         => 'FlixzaGlobal Admin',
            'email'        => 'admin@flixzaglobal.com',
            'password'     => Hash::make('flixza@admin'),
            'account_role' => '0',
        ]);
    }
}
