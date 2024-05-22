<?php
// UserCreateController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Helpers\LogActivityHelper;
use App\Helpers\NotificationSender;
use App\Models\reg_user;
use App\Models\extra_benifits;
use App\Models\otherBenifitsbyPercentage;
use App\Models\department;
use App\Models\academic;
use App\Models\UsersProfessionalCertificate;
use App\Models\hobbies;
use App\Models\medicalHistory;
use App\Models\JobExpriences;
use App\Models\UsersChildInfo;
use Illuminate\Support\Facades\Auth;
##SMS
use Xenon\LaravelBDSms\Provider\BulkSmsBD;
use Xenon\LaravelBDSms\Sender;
##SMS
#use Xenon\LaravelBDSms\Provider\BulkSmsBD;
#use Xenon\LaravelBDSms\Sender;

class UserController extends Controller{

    public function all_users_index() {
        return view('AdminLTE/frontend/Users/AjaxDataTable');
    }

    public function create() {
        $department=department::all();
        return view('AdminLTE/frontend/Users/create_users',['department' => $department]);
    }


  public function create_users(Request $request) {
     $validator = Validator::make($request->all(), [
        'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:10000',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => ['required', 'string', 'min:4'],
        'designation' => 'required|string',
        'address' => 'required|string',
        'department_name' => 'required|string',
        'otithee_joining_date' => 'required|date',
        'blood_group' => 'sometimes|string',
        'nationality_country' => 'required|string',
        'DOB' => 'required|date',
        'pay_frequency' => 'required|string',
        'bonus_information' => 'required|string',
        'extra_benefits' => 'required|string',
        'curriculum_vita_cv' => 'required|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:50240',
         //======> degree
        'degree_information.*' => 'required|string',
        'degree.*' => 'required|string',
        'joining_year.*' => 'sometimes|date',
        'passing_year.*' => 'required|date',
        // ======> end
        'nid_Information' => 'required|string',
        'gender' => 'required|string',
        'phoneCountry' => 'required|string',
        'phone_number' => 'required|string|unique:users,phone_number',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $user = new reg_user();
    $user->attendance_uid = $request->input('attendance_uid');
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    $user->designation = $request->input('designation');
    $user->address = $request->input('address');
    $user->department_name = $request->input('department_name');
    $user->otithee_joining_date = $request->input('otithee_joining_date');
    $user->blood_group = $request->input('blood_group');
    $user->nationality_country = $request->input('nationality_country');
    $user->dob = $request->input('DOB');
    $user->totalAmount = $request->input('totalAmount');
    $user->normal_salary = $request->input('normal_salary');
    $user->pay_frequency = $request->input('pay_frequency');
    $user->healthcare_insurance = $request->input('healthcare_insurance');
    $user->providend_fund = $request->input('providend_fund'); 
    $user->bonus_information = $request->input('bonus_information');
    $user->extra_benefits = $request->input('extra_benefits');
    $user->mobile_bill = $request->input('mobile_bill');
    $user->nid_Information = $request->input('nid_Information');
    $user->language = $request->input('language');
    $user->gender = $request->input('gender');
    $user->marital_status = $request->input('marital_status');
    $user->spouse_name = $request->input('spouse_name');
    $user->spouse_birthday = $request->input('spouse_birthday');
    $user->spouse_nid = $request->input('spouse_nid');
    $user->spouse_anniversary = $request->input('spouse_anniversary'); 
    $user->medical_history_others=$request->input('medical_history_others');
    $user->hobbies_and_interest=$request->input('hobbies_and_interest');
    $user->phoneCountry = $request->input('phoneCountry');
    $user->phone_number = $request->input('phone_number');
    $user->father_name = $request->input('father_name');
    $user->father_occupation = $request->input('father_occupation');
    $user->mother_name = $request->input('mother_name');
    $user->mother_occupation = $request->input('mother_occupation');
    $user->emergency_contact_name_1 = $request->input('emergency_contact_name_1');
    $user->emergency_contact_number_1 = $request->input('emergency_contact_number_1');
    $user->emergency_contact_relationship_1 = $request->input('emergency_contact_relationship_1');
    $user->emergency_contact_name_2 = $request->input('emergency_contact_name_2');
    $user->emergency_contact_number_2 = $request->input('emergency_contact_number_2');
    $user->emergency_contact_relationship_2 = $request->input('emergency_contact_relationship_2');
    $user->facebook_link = $request->input('facebook_link');
    $user->twitter_link = $request->input('twitter_link');
    $user->instagram_link = $request->input('instagram_link');
    $user->linkedin_link = $request->input('linkedin_link');
    $user->tiktok_link = $request->input('tiktok_link');
    $user->youtube_link = $request->input('youtube_link');
    # Payment Profile
    $user->bank_account_number_official = $request->input('bank_account_number_official');
    $user->bkash_account_number = $request->input('bkash_account_number');
    $user->nogod_account_number = $request->input('nogod_account_number');
    $user->rocket_account_number = $request->input('rocket_account_number');
     ## User image 1
     $image1 = $request->file('profile_pic');
     if ($request->hasfile('profile_pic')) {
         $extension = $image1->getClientOriginalExtension();
         $department_image_name = $user->name . '-phone_number-.' . $extension;
         $image1->move('assets/users/', $department_image_name);
         $user->profile_pic = $department_image_name;
      }
    ## UploadCV
     $CV = $request->file('curriculum_vita_cv');
     if ($request->hasfile('curriculum_vita_cv')) {
         $extension = $CV->getClientOriginalExtension();
         $UserCV = $user->phone_number . '-CV-.' . $extension;
         $CV->move('assets/users/UserCV/', $UserCV);
         $user->curriculum_vita_cv = $UserCV;
      }
    # save the user to the database
    $user->save();
    $lastInsertID=$user->id;

  ######### degree_information #########
  $academicData = $request->input('degree_information');
  if (!empty($academicData)) {
      $academicRecords = [];
  
      foreach ($academicData as $key => $degreeInformation) {
          if (!empty($degreeInformation)) {
              $academicRecords[] = [
                  'degree_information' => $degreeInformation,
                  'degree' => $request->input('degree')[$key],
                  'join_year' => $request->input('joining_year')[$key],
                  'pass_year' => $request->input('passing_year')[$key],
                  'user_id' => $lastInsertID,
              ];
          }
      }
  
      if (!empty($academicRecords)) {
          Academic::insert($academicRecords);
      }
  }


######### OPTIMIZE cert_name CODE #########
$certificatesData = [];
foreach ($request->input('cert_name') as $key => $professionalInformation) {
    if (!empty($professionalInformation)) {
        $certificatesData[] = [
            'certificate_name' => $professionalInformation,
            'organization_name' => $request->input('cert_org_name')[$key],
            'start_date' => $request->input('cert_start_date')[$key],
            'end_date' => $request->input('cert_end_date')[$key],
            'user_id' => $lastInsertID,
        ];
    }
}
if (!empty($certificatesData)) {
    UsersProfessionalCertificate::insert($certificatesData);
}

######### jobExperienceData #########
$jobExperienceData = [];
if ($request->has('job_designation_name') && !empty($request->input('job_designation_name'))) {
    foreach ($request->input('job_designation_name') as $key => $jobDesignation) {
        if (!empty($jobDesignation)) {
            $jobExperienceData[] = [
                'job_designation_name' => $jobDesignation,
                'job_org_name' => $request->input('job_org_name')[$key],
                'job_start_date' => $request->input('job_start_date')[$key],
                'job_end_date' => $request->input('job_end_date')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
}
if (!empty($jobExperienceData)) {
    JobExpriences::insert($jobExperienceData);
}

######### childInfoData #########
$childInfoData = [];
if ($request->has('child_name') && !empty($request->input('child_name'))) {
    foreach ($request->input('child_name') as $key => $childName) {
        if (!empty($childName)) {
            $childInfoData[] = [
                'child_name' => $childName,
                'child_gender' => $request->input('child_gender')[$key],
                'child_birthday' => $request->input('child_birthday')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
}

if (!empty($childInfoData)) {
    UsersChildInfo::insert($childInfoData);
}

######### other_benifits_name #########
$otherBenifitsData = [];
if ($request->has('other_benifits_name') && !empty($request->input('other_benifits_name'))) {
    foreach ($request->input('other_benifits_name') as $key => $BenifitsbyPercentage) {
        if (!empty($BenifitsbyPercentage)) {
            $otherBenifitsData[] = [
                'other_benifits_name' => $BenifitsbyPercentage,
                'other_benifits_by_percentage' => $request->input('other_benifits_by_percentage')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
}

if (!empty($otherBenifitsData)) {
    OtherBenifitsbyPercentage::insert($otherBenifitsData);
}

######### benifitsData #########
$benifitsData = [];
if ($request->has('benifits_name') && !empty($request->input('benifits_name'))) {
    foreach ($request->input('benifits_name') as $key => $professonalformationbenifits_name) {
        if (!empty($professonalformationbenifits_name)) {
            $benifitsData[] = [
                'benifits_name' => $professonalformationbenifits_name,
                'benifits_amount' => $request->input('benifits_amount')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
}
if (!empty($benifitsData)) {
    extra_benifits::insert($benifitsData);
}

######### historyData #########
$historyData = [];
if ($request->has('medical_history') && !empty($request->input('medical_history'))) {
    foreach ($request->input('medical_history') as $key => $professonalformationhistory) {
        if (!empty($professonalformationhistory)) {
            $historyData[] = [
                'medical_history' => $professonalformationhistory,
                'user_id' => $lastInsertID,
            ];
        }
    }
}
if (!empty($historyData)) {
    medicalHistory::insert($historyData);
}

######### hobbiesData #########
$hobbiesData = [];
if ($request->has('hobbies') && !empty($request->input('hobbies'))) {
    foreach ($request->input('hobbies') as $key => $professonalformationhobbies) {
        if (!empty($professonalformationhobbies)) {
            $hobbiesData[] = [
                'hobbies' => $professonalformationhobbies,
                'user_id' => $lastInsertID,
            ];
        }
    }
}
if (!empty($hobbiesData)) {
    hobbies::insert($hobbiesData);
}

######### SMS SEND #########
/* $sender = Sender::getInstance();
$sender->setProvider(BulkSmsBD::class);
$sender->setMobile($request->input('phone_number'));
$sender->setMessage('Hi '. $request->input('name') . '! Welcome to OEMS! Your Login ID:'. $request->input('phone_number') .'; Password:'. $request->input('password') .'Login: https://otitheesoftwaresolution.com');
$sender->setQueue(true); 
$sender->setConfig(
[
   'api_key' => 'qfI5bCOCc04w4812MUv4',
   'type' => 'text',
   'senderid' => '8809617615488',
]
);
$status = $sender->send(); */
######### SMS SEND END #########

 #return redirect()->route('users_home')->with('success', '`' . $user->name . '` Successfully Added' . '<a href="/employee/ID/'. $user->phone_number .'">Check Profile</a>');
 return response()->json(['message' => 'User created successfully']);
}


public function edit(Request $request, $id){
    $user_data= reg_user::find($id); 
    $academic = Academic::where('user_id', $id)->get();
    $UsersProfessionalCertificate = UsersProfessionalCertificate::where('user_id', $id)->get(); 
    $JobExpriences = JobExpriences::where('user_id', $id)->get(); 
    $UsersChildInfo = UsersChildInfo::where('user_id', $id)->get(); 
    $extra_benifits = extra_benifits::where('user_id', $id)->get(); 
    $otherbyPercentage = otherBenifitsbyPercentage::where('user_id', $id)->get(); 
    $hobbies = hobbies::where('user_id', $id)->get(); 
    $selectedHobbies = ['Reading', 'Writing', 'Painting', 'Drawing', 'Playing Musical Instruments', 'Singing', 'Dancing', 'Photography', 'Cooking', 'Gardening', 'Traveling', 'Sports', 'Gaming', 'Crafting', 'Yoga']; 
    $medicalHistory = medicalHistory::where('user_id', $id)->get(); 
    $selectedMedicalHistory = ['High Blood Pressure','Diabetes','Asthma','Heart Disease','Cancer','Stroke','Depression','Anxiety','Obesity','Chronic Kidney Disease','Chronic Obstructive Pulmonary Disease (COPD)','Rheumatoid Arthritis','Osteoporosis','Anemia','Thyroid Disorders','Gastrointestinal Disorders']; 
    $department=department::all();

    return view('AdminLTE/frontend/Users/edit_user_profile', [
        'user_data' => $user_data,
        'academic' => $academic,
        'UsersProfessionalCertificate' => $UsersProfessionalCertificate,
        'UsersChildInfo' => $UsersChildInfo,
        'JobExpriences' => $JobExpriences,
        'extra_benifits' => $extra_benifits,
        'otherbyPercentage' => $otherbyPercentage,
        'hobbies' => $hobbies,
        'selectedHobbies' => $selectedHobbies,
        'selectedMedicalHistory' => $selectedMedicalHistory,
        'medicalHistory' => $medicalHistory,
        'department' => $department,
    
    ]);
}



public function update_users(Request $request, $id){
    $validator = Validator::make($request->all(), [
        'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
        'name' => 'required|string|max:255',
        'designation' => 'required|string',
        'address' => 'required|string',
        'department_name' => 'required|string',
        'otithee_joining_date' => 'required|date',
        'nationality_country' => 'required|string',
        'DOB' => 'required|date',
        // Add other validation rules 
        'nid_Information' => 'required|string',
        'gender' => 'required|string',
        'phoneCountry' => 'required|string',
        'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:5120',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($id),
        ],

        'phoneCountry' => 'required|string',
        'phone_number' => [
            'required',
            'string',
            Rule::unique('users', 'phone_number')->ignore($id),
        ],
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }
    # Find User instance
    $user = reg_user::find($id);
    $user->attendance_uid = $request->input('attendance_uid');
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    if ($request->filled('password')) {
    $user->password = Hash::make($request->input('password')); 
    }
    $user->designation = $request->input('designation');
    $user->address = $request->input('address');
    $user->department_name = $request->input('department_name');
    $user->otithee_joining_date = $request->input('otithee_joining_date');
    $user->blood_group = $request->input('blood_group');
    $user->nationality_country = $request->input('nationality_country');
    $user->dob = $request->input('DOB');
    $user->totalAmount = $request->input('totalAmount');
    $user->normal_salary = $request->input('normal_salary');
    $user->pay_frequency = $request->input('pay_frequency');
    $user->healthcare_insurance = $request->input('healthcare_insurance');
    $user->providend_fund = $request->input('providend_fund'); 
    $user->bonus_information = $request->input('bonus_information');
    $user->extra_benefits = $request->input('extra_benefits');
    $user->mobile_bill = $request->input('mobile_bill');
    $user->nid_Information = $request->input('nid_Information');
    $user->language = $request->input('language');
    $user->gender = $request->input('gender');
    $user->marital_status = $request->input('marital_status');
    $user->spouse_name = $request->input('spouse_name');
    $user->spouse_birthday = $request->input('spouse_birthday');
    $user->spouse_nid = $request->input('spouse_nid');
    $user->spouse_anniversary = $request->input('spouse_anniversary'); 
    $user->medical_history_others=$request->input('medical_history_others');
    $user->hobbies_and_interest=$request->input('hobbies_and_interest');
    $user->phoneCountry = $request->input('phoneCountry');
    $user->phone_number = $request->input('phone_number');
    $user->father_name = $request->input('father_name');
    $user->father_birthday = $request->input('father_birthday');
    $user->father_occupation = $request->input('father_occupation');
    $user->mother_name = $request->input('mother_name');
    $user->mother_birthday = $request->input('mother_birthday');
    $user->mother_occupation = $request->input('mother_occupation');
    $user->emergency_contact_name_1 = $request->input('emergency_contact_name_1');
    $user->emergency_contact_number_1 = $request->input('emergency_contact_number_1');
    $user->emergency_contact_relationship_1 = $request->input('emergency_contact_relationship_1');
    $user->emergency_contact_name_2 = $request->input('emergency_contact_name_2');
    $user->emergency_contact_number_2 = $request->input('emergency_contact_number_2');
    $user->emergency_contact_relationship_2 = $request->input('emergency_contact_relationship_2');
    $user->facebook_link = $request->input('facebook_link');
    $user->twitter_link = $request->input('twitter_link');
    $user->instagram_link = $request->input('instagram_link');
    $user->linkedin_link = $request->input('linkedin_link');
    $user->tiktok_link = $request->input('tiktok_link');
    $user->youtube_link = $request->input('youtube_link');
    # payment profile
    $user->bank_account_number_official = $request->input('bank_account_number_official');
    $user->bkash_account_number = $request->input('bkash_account_number');
    $user->nogod_account_number = $request->input('nogod_account_number');
    $user->rocket_account_number = $request->input('rocket_account_number');
     ## user image 1
     $image1 = $request->file('profile_pic');
     if ($request->hasfile('profile_pic')) {
         $extension = $image1->getClientOriginalExtension();
         $department_image_name = $user->name . '-phone_number-.' . $extension;
         $image1->move('assets/users/', $department_image_name);
         $user->profile_pic = $department_image_name;
      }

## UploadCV
$CV = $request->file('curriculum_vita_cv');
if ($request->hasfile('curriculum_vita_cv')) {
    // Delete the old CV file if it exists
    if ($user->curriculum_vita_cv) {
        file::delete('assets/users/UserCV/' . $user->curriculum_vita_cv);
    }
    // Move the new CV file
    $UserCV = $user->phone_number . '-CV-' . $CV->getClientOriginalName();
    $CV->move('assets/users/UserCV/', $UserCV);
    $user->curriculum_vita_cv = $UserCV;
    }
    # save the user to the database
    $user->save();
    $lastInsertID=$id;

######### degree_information #########
if ($request->has('degree_information') && !empty($request->input('degree_information'))) {
    Academic::where('user_id', $lastInsertID)->delete();
    $academicData = [];
    foreach ($request->input('degree_information') as $key => $degreeInformation) {
        // Check if 'degree_information' is not empty
        if (!empty($degreeInformation)) {
            $academicData[] = [
                'degree_information' => $degreeInformation,
                'degree' => $request->input('degree')[$key],
                'join_year' => $request->input('joining_year')[$key],
                'pass_year' => $request->input('passing_year')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
    if (!empty($academicData)) {
        Academic::insert($academicData);
    }
}

######### cert_name #########
if ($request->has('cert_name') && !empty($request->input('cert_name'))) {
    UsersProfessionalCertificate::where('user_id', $lastInsertID)->delete();
    $certificatesData = [];
    foreach ($request->input('cert_name') as $key => $professionalInformation) {
        if (!empty($professionalInformation)) {
            $certificatesData[] = [
                'certificate_name' => $professionalInformation,
                'organization_name' => $request->input('cert_org_name')[$key],
                'start_date' => $request->input('cert_start_date')[$key],
                'end_date' => $request->input('cert_end_date')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }

    if (!empty($certificatesData)) {
        UsersProfessionalCertificate::insert($certificatesData);
    }
}

######### job_designation_name #########
if ($request->has('job_designation_name') && !empty($request->input('job_designation_name'))) {
    JobExpriences::where('user_id', $lastInsertID)->delete();
    $jobExperiencesData = [];
    foreach ($request->input('job_designation_name') as $key => $jobDesignation) {
        if (!empty($jobDesignation)) {
            $jobExperiencesData[] = [
                'job_designation_name' => $jobDesignation,
                'job_org_name' => $request->input('job_org_name')[$key],
                'job_start_date' => $request->input('job_start_date')[$key],
                'job_end_date' => $request->input('job_end_date')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
    if (!empty($jobExperiencesData)) {
        JobExpriences::insert($jobExperiencesData);
    }
}

######### child_name #########
if ($request->has('child_name') && !empty($request->input('child_name'))) {
    UsersChildInfo::where('user_id', $lastInsertID)->delete();
    $childInfoData = [];
    foreach ($request->input('child_name') as $key => $childName) {
        if (!empty($childName)) {
            $childInfoData[] = [
                'child_name' => $childName,
                'child_gender' => $request->input('child_gender')[$key],
                'child_birthday' => $request->input('child_birthday')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
    if (!empty($childInfoData)) {
        UsersChildInfo::insert($childInfoData);
    }
}

######### benifits_name #########
if ($request->has('benifits_name') && !empty($request->input('benifits_name'))) {
    extra_benifits::where('user_id', $lastInsertID)->delete();
    $benifitsData = [];

    foreach ($request->input('benifits_name') as $key => $professonalformationbenifits_name) {
        if (!empty($professonalformationbenifits_name)) {
            $benifitsData[] = [
                'benifits_name' => $professonalformationbenifits_name,
                'benifits_amount' => $request->input('benifits_amount')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
    if (!empty($benifitsData)) {
        extra_benifits::insert($benifitsData);
    }
}

######### other_benifits_name #########
if ($request->has('other_benifits_name') && !empty($request->input('other_benifits_name'))) {
    OtherBenifitsbyPercentage::where('user_id', $lastInsertID)->delete();
    $otherBenifitsData = [];
    foreach ($request->input('other_benifits_name') as $key => $professonalformationbenifits_name) {
        if (!empty($professonalformationbenifits_name)) {
            $otherBenifitsData[] = [
                'other_benifits_name' => $professonalformationbenifits_name,
                'other_benifits_by_percentage' => $request->input('other_benifits_by_percentage')[$key],
                'user_id' => $lastInsertID,
            ];
        }
    }
    
    # Insert the new 'other_benifits_name' records
    if (!empty($otherBenifitsData)) {
        OtherBenifitsbyPercentage::insert($otherBenifitsData);
    }
}

######### historyData #########
if ($request->has('medical_history') && is_array($request->input('medical_history'))) {
    if (!empty($request->input('medical_history'))) {
        medicalHistory::where('user_id', $lastInsertID)->delete();
        // Prepare data for insertion
        $historyData = [];
        foreach ($request->input('medical_history') as $history) {
            if (!empty($history)) {
                $historyData[] = [
                    'medical_history' => $history,
                    'user_id' => $lastInsertID,
                ];
            }
        }

        if (!empty($historyData)) {
            medicalHistory::insert($historyData);
        }
    } else {
        medicalHistory::where('user_id', $lastInsertID)->delete();
    }
}

######### hobbiesData #########
if ($request->has('hobbies') && !empty($request->input('hobbies'))) {
    // Delete existing Hobbies records for the user
    Hobbies::where('user_id', $lastInsertID)->delete();
    $hobbiesData = [];
    foreach ($request->input('hobbies') as $key => $hobby) {
        if (!empty($hobby)) {
            $hobbiesData[] = [
                'hobbies' => $hobby,
                'user_id' => $lastInsertID,
            ];
        }
    }

    if (!empty($hobbiesData)) {
        Hobbies::insert($hobbiesData);
    }
}


LogActivityHelper::addToLog('<a href="' . url("employee/ID/{$user->phone_number}") . '" target="_blank">' . $user->name . "'s</a> Account Has Been Edited by " . auth()->user()->name, $request);
NotificationSender::NotificationSend($user->name . '\'s Account Has Been Edited by ' . auth()->user()->name, $request);
return redirect()->route('users_home')->with('success', '`' . $user->name = $request->input('name') .'` Information Successfully Updated');
}

public function destroy(Request $request, $id){
    $auth_number = Auth::user()->phone_number;
    $auth_email = Auth::user()->email;
    if($auth_number == '01878578504' && $auth_email == 'needyamin@gmail.com'){
    $item = reg_user::find($id);
    if (!$item) {
        return redirect()->route('users_home')->with('error', 'Item not found!');
    }
    # if found profile pic
    $destination = public_path('/assets/users/') . $item->profile_pic;
    if (File::exists($destination)) {
        File::delete($destination);
    }
    # if found CV
    $UpLoadCV=  public_path('/assets/users/UserCV/') . $item->curriculum_vita_cv;
    if (File::exists($UpLoadCV)) {
        File::delete($UpLoadCV);
    }
    
    LogActivityHelper::addToLog('Account Has Been Deleted', $request);
    $item->delete();
    return redirect()->route('users_home')->with('success', '`'. $item->name . '` has been deleted!');
}

else {
    return redirect()->route('users_home')->with('error', 'You can\'t delete this items. Please contact with superadmin');
}

}


}


