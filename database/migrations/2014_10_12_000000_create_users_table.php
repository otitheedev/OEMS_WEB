<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('attendance_uid')->unique()->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('designation')->nullable();
            $table->longtext('address')->nullable();
            $table->string('department_name')->nullable();
            $table->string('otithee_joining_date')->nullable();
            $table->string('otithee_left_date')->nullable(); ## later added
            $table->string('otithee_reporting manager')->nullable(); ## later added
            $table->string('blood_group')->nullable();
            $table->string('nationality_country')->nullable();
            $table->date('DOB')->nullable();
            $table->boolean('birthday_sms_sent')->default(false);

             # Compensation and Benefits
             $table->string('totalAmount')->nullable();
             $table->string('normal_salary')->nullable();
             $table->string('pay_frequency')->nullable();
             $table->string('healthcare_insurance')->nullable();
             $table->string('providend_fund')->nullable();
             $table->string('bonus_information')->nullable();
             $table->string('extra_benefits')->nullable();
             $table->string('mobile_bill')->nullable();
             
             #Other Inforamtion
             $table->string('height')->nullable();
             $table->string('weight')->nullable();
             $table->string('nid_Information')->nullable();

             $table->string('language')->nullable();
             $table->string('gender')->nullable();
             $table->string('marital_status')->nullable();
             $table->string('spouse_name')->nullable();
             $table->date('spouse_birthday')->nullable();
             $table->string('spouse_nid')->nullable();
             $table->date('spouse_anniversary')->nullable();
             $table->string('phoneCountry')->nullable();
             $table->string('phone_number')->unique();
             $table->string('password');

            # Family Information 
            $table->string('father_name')->nullable();
            $table->date('father_birthday')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('mother_birthday')->nullable();
            $table->string('mother_occupation')->nullable();

            # Emergency Contact
            $table->string('emergency_contact_name_1')->nullable();
            $table->string('emergency_contact_number_1')->nullable();
            $table->string('emergency_contact_relationship_1')->nullable();
            $table->string('emergency_contact_name_2')->nullable();
            $table->string('emergency_contact_number_2')->nullable();
            $table->string('emergency_contact_relationship_2')->nullable();

            # Contact Details
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->string('youtube_link')->nullable();

            #Medical History
            $table->longtext('medical_history_others')->nullable();
            $table->longtext('hobbies_and_interest')->nullable();
            
            # Leave and Time-off Details:
            $table->string('work_authorization')->nullable();
            $table->string('curriculum_vita_cv')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
  
    public function down(): void
    {
    Schema::table('users', function (Blueprint $table) {
    });
     }

};
