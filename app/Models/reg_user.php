<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reg_user extends Model
{
    #use HasFactory;
    protected $table='users';
    
    protected $fillable=[
        'profile_pic',
        'name',
        'email',
        'email_verified_at',
        'designation',
        'address',
        'department_name',
        'otithee_joining_date',
        'otithee_left_date',
        'otithee_reporting_manager',
        'blood_group',
        'nationality_country',
        'DOB',
        'normal_salary',
        'pay_frequency',
        'healthcare_insurance',
        'providend_fund',
        'bonus_information',
        'extra_benefits',
        'mobile_bill',
        'nid_Information',
        'language',
        'gender',
        'marital_status',
        'spouse_name',
        'spouse_birthday',
        'spouse_nid',
        'spouse_anniversary',
        'phoneCountry',
        'phone_number',
        'password',
        'father_name',
        'father_birthday',
        'father_occupation',
        'mother_name',
        'mother_birthday',
        'mother_occupation',
        'emergency_contact_name_1',
        'emergency_contact_number_1',
        'emergency_contact_relationship_1',
        'emergency_contact_name_2',
        'emergency_contact_number_2',
        'emergency_contact_relationship_2',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linkedin_link',
        'tiktok_link',
        'youtube_link',
        'medical_history_others',
        'hobbies_and_interest',
        'work_authorization',
        'curriculum_vita_cv',
        'birthday_sms_sent',
    ];

    ####################################################################
    public function academicRecords(){
        return $this->hasMany(academic::class, 'user_id', 'id');
    }

    public function professional_certificate()
    {
        return $this->hasMany(UsersProfessionalCertificate::class, 'user_id', 'id');
    }
    
    public function job_expriences()
    {
        return $this->hasMany(JobExpriences::class, 'user_id', 'id');
    }

    public function child_info()
    {
        return $this->hasMany(UsersChildInfo::class, 'user_id', 'id');
    }


    public function otherBenifitsbyPercentage()
    {
        return $this->hasMany(otherBenifitsbyPercentage::class, 'user_id', 'id');
    }

    public function extra_benifits()
    {
        return $this->hasMany(extra_benifits::class, 'user_id', 'id');
    }

    
    public function medicalHistory()
    {
        return $this->hasMany(medicalHistory::class, 'user_id', 'id');
    }
    
    public function hobbies()
    {
        return $this->hasMany(hobbies::class, 'user_id', 'id');
    }




    public function UserNameActivity()
    {
        return $this->hasMany('App\Models\APIModel\activitylogs', 'user_id', 'id');
    }

    ######################################################################

}
