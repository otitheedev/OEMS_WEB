<?php

// DatabaseSeeder.php
namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\reg_user;
use App\Models\adminRole\adminUserRole;
use Faker\Factory as Faker; // Add Faker

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
      $faker = Faker::create();
        
      $admin = reg_user::where('email','needyamin@gmail.com')->first(); 
      if (!$admin) {
       # Seed a admin user
       $user = reg_user::create([
            'profile_pic' => 'https://needyamin.github.io/core/img/YAMiN_HOSSAIN.png',
            'email' => 'needyamin@gmail.com',
            'phone_number' => '01878578504',
            'password' => Hash::make('01878578504'),
            'name' => 'Md. Yamin Hossain', 
            'designation' => $faker->jobTitle,
            'address' => $faker->address,
            'department_name' => $faker->word,
            'otithee_joining_date' => $faker->date,
            'otithee_left_date' => $faker->date,
            'otithee_reporting manager' => $faker->name,
            'blood_group' => $faker->randomElement(['A+', 'B+', 'O+', 'AB+']),
            'nationality_country' => $faker->country,
            'DOB' => $faker->date,
            'birthday_sms_sent' => $faker->boolean,
            'height' => $faker->randomFloat(2, 150, 200),
            'weight' => $faker->randomFloat(2, 50, 100),
            'nid_Information' => $faker->uuid,
            'language' => $faker->languageCode,
            'gender' => $faker->randomElement(['Male', 'Female']),
            'marital_status' => $faker->randomElement(['Single', 'Married', 'Divorced']),
            'spouse_name' => $faker->name,
            'spouse_birthday' => $faker->date,
            'spouse_nid' => $faker->uuid,
            'spouse_anniversary' => $faker->date,
            'phoneCountry' => $faker->countryCode,
            'father_name' => $faker->name,
            'father_birthday' => $faker->date,
            'father_occupation' => $faker->jobTitle,
            'mother_name' => $faker->name,
            'mother_birthday' => $faker->date,
            'mother_occupation' => $faker->jobTitle,
            'emergency_contact_name_1' => $faker->name,
            'emergency_contact_number_1' => $faker->phoneNumber,
            'emergency_contact_relationship_1' => $faker->randomElement(['Friend', 'Family', 'Colleague']),
            'emergency_contact_name_2' => $faker->name,
            'emergency_contact_number_2' => $faker->phoneNumber,
            'emergency_contact_relationship_2' => $faker->randomElement(['Friend', 'Family', 'Colleague']),
            'facebook_link' => $faker->url,
            'twitter_link' => $faker->url,
            'instagram_link' => $faker->url,
            'linkedin_link' => $faker->url,
            'tiktok_link' => $faker->url,
            'youtube_link' => $faker->url,
            'medical_history_others' => $faker->paragraph,
            'hobbies_and_interest' => $faker->paragraph,
            'work_authorization' => $faker->word,
            'curriculum_vita_cv' => $faker->url,
        ]);
        $lastID = $user->id;

  
      $this->call(RoleSeeder::class);
      $this->call(PermissionSeeder::class);
      // Call additional seeders if needed

      
    }
    
    }
}