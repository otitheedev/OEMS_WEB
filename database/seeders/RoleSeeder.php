<?php

// RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\reg_user;

// RoleSeeder.php
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        // Add more roles if needed

        // Assign user role to admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin = reg_user::where('email', 'needyamin@gmail.com')->first(); 
            if ($admin) {
                // Using DB facade to insert data
                DB::table('role_user')->insert([
                    'user_id' => $admin->id,
                    'role_id' => $adminRole->id,
                ]);
            }
        }
    }
}
