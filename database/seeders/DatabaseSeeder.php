<?php

// DatabaseSeeder.php
namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\reg_user;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        // Call additional seeders if needed

        // Seed a sample user
       $user = reg_user::create([
            'profile_pic' => 'https://needyamin.github.io/core/img/YAMiN_HOSSAIN.png',
            'email' => 'needyamin@gmail.com',
            'phone_number' => '01878578504',
            'password' => Hash::make('needyamin@gmail.com'),
            'name' => 'Md. Yamin Hossain', // Add other fields as needed
            // Add other fields as needed
        ]);

      $lastID = $user->id;

      

    
    }
}