<?php

// PermissionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'create_post']);
        Permission::create(['name' => 'edit_post']);
        Permission::create(['name' => 'delete_post']);
        // Add more permissions if needed
    }
}
