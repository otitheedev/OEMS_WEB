<?php
// UserCreateController.php

namespace App\Http\Controllers;

use App\Models\reg_user;
use App\Models\extra_benifits;
use App\Models\otherBenifitsbyPercentage;
use App\Models\department;
use App\Models\academic;
use App\Models\UsersProfessionalCertificate;
use App\Models\JobExpriences;
use App\Models\UsersChildInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;


##SMS
#use Xenon\LaravelBDSms\Provider\BulkSmsBD;
#use Xenon\LaravelBDSms\Sender;


class UserController extends Controller
{

 public function all_users_index()
    {
        $user=reg_user::all();
        #return view('AdminLTE/frontend/Users/users',['user' => $user]);
        return view('AdminLTE/frontend/Users/AjaxDataTable',['user' => $user]);
       
    }



    public function create()
    {
        return view('AdminLTE/frontend/Users/create_users');
    }

    public function admin_dashboard(){
   
    
         $users_count= reg_user::count();
         $department_count= department::count();
        return view('AdminLTE/index',[
            'users_count' => $users_count,
            'department_count' => $department_count, 
        ]);
    }



public function create_users(Request $request)
{
    //return $request;
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
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

         // Add other validation rules for user fields ##FOREACH START NEEDYAMIN
         //======> degree
        'degree_information.*' => 'required|string',
        'degree.*' => 'required|string',
        'joining_year.*' => 'sometimes|date',
        'passing_year.*' => 'required|date',


        // Add other validation rules for academic fields ##FOREACH END NEEDYAMIN

        'nid_Information' => 'required|string',
        'gender' => 'required|string',
        'phoneCountry' => 'required|string',
        'phone_number' => 'required|string|unique:users,phone_number',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Create a new User instance
    $user = new reg_user();

    // Set user attributes from the request data
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password')); // Hash the password
    $user->designation = $request->input('designation');
    $user->address = $request->input('address');
    $user->department_name = $request->input('department_name');
    $user->otithee_joining_date = $request->input('otithee_joining_date');
    $user->blood_group = $request->input('blood_group');
    $user->nationality_country = $request->input('nationality_country');
    $user->dob = $request->input('DOB');
    
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
    $user->medical_history=$request->input('medical_history');
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

 if ($request->has('degree_information') && !empty($request->input('degree_information'))) {
    
    # loop academic data and associate it with the user 
     foreach ($request->input('degree_information') as $key => $degreeInformation) {
        
         # Check if 'certificate_name' is not empty 
        if (!empty($degreeInformation)) {
        Academic::create([
            'degree_information' => $degreeInformation,
            'degree' => $request->input('degree')[$key],
            'join_year' => $request->input('joining_year')[$key],
            'pass_year' => $request->input('passing_year')[$key],
            'user_id' => $lastInsertID,
        ]);
    }
    }
  } 


  if ($request->has('cert_name') && !empty($request->input('cert_name'))) {
    foreach ($request->input('cert_name') as $key => $professionalInformation) {

         #Check if 'certificate_name' is not empty before creating the record
        if (!empty($professionalInformation)) {
            UsersProfessionalCertificate::create([
                'certificate_name' => $professionalInformation,
                'organization_name' => $request->input('cert_org_name')[$key],
                'start_date' => $request->input('cert_start_date')[$key],
                'end_date' => $request->input('cert_end_date')[$key],
                'user_id' => $lastInsertID,
            ]);
        }
    }
}


if ($request->has('job_designation_name') && !empty($request->input('job_designation_name'))) {
    ## loop job_designation_namedata and associate it with the Users
    foreach ($request->input('job_designation_name') as $key => $JobExpriencesformation) {
        # Check if 'certificate_name' is not empty 
        if (!empty($JobExpriencesformation)) {
        JobExpriences::create([
            'job_designation_name' => $JobExpriencesformation,
            'job_org_name' => $request->input('job_org_name')[$key],
            'job_start_date' => $request->input('job_start_date')[$key],
            'job_end_date' => $request->input('job_end_date')[$key],
            'user_id' => $lastInsertID,
        ]);
    }
  }
}


if ($request->has('child_name') && !empty($request->input('child_name'))) {
    ## loop childInfo data and associate it with the Users
    foreach ($request->input('child_name') as $key => $professonalformation) {
        
        # Check if 'child_name' is not empty 
        if (!empty($professonalformation)) {
        UsersChildInfo::create([
            'child_name' => $professonalformation,
            'child_gender' => $request->input('child_gender')[$key],
            'child_birthday' => $request->input('child_birthday')[$key],
            'user_id' => $lastInsertID,
        ]);
    }
  }
}

############## other_benifits_by_percentage start #################
if ($request->has('other_benifits_name') && !empty($request->input('other_benifits_name'))) {
    ## loop childInfo data and associate it with the Users
    foreach ($request->input('other_benifits_name') as $key => $BenifitsbyPercentage) {
        
        # Check if 'benifits_name' is not empty 
        if (!empty($BenifitsbyPercentage)) {
            otherBenifitsbyPercentage::create([
            'other_benifits_name' => $BenifitsbyPercentage,
            'other_benifits_by_percentage' => $request->input('other_benifits_by_percentage')[$key],
            #'benifits_amount' => $request->input('benifits_amount')[$key],
            'user_id' => $lastInsertID,
        ]);
    }
  }
}
############## other_benifits_by_percentage end #################


if ($request->has('benifits_name') && !empty($request->input('benifits_name'))) {
    ## loop childInfo data and associate it with the Users
    foreach ($request->input('benifits_name') as $key => $professonalformationbenifits_name) {
        
        # Check if 'benifits_name' is not empty 
        if (!empty($professonalformationbenifits_name)) {
            extra_benifits::create([
            'benifits_name' => $professonalformationbenifits_name,
            'benifits_amount' => $request->input('benifits_amount')[$key],
            'user_id' => $lastInsertID,
        ]);
    }
  }
}

    return redirect()->route('users_home')->with('success', '`' . $user->name . '` Successfully Added' . '<a href="/employee/ID/'. $user->phone_number .'">Check Profile</a>');
    #return response()->json(['message' => 'User created successfully'], 201);
}


public function edit(Request $request, $id)
{
    $user_data= reg_user::find($id); 
    $academic = Academic::where('user_id', $id)->get();
    $UsersProfessionalCertificate = UsersProfessionalCertificate::where('user_id', $id)->get(); 
    $JobExpriences = JobExpriences::where('user_id', $id)->get(); 
    $UsersChildInfo = UsersChildInfo::where('user_id', $id)->get(); 
    $extra_benifits = extra_benifits::where('user_id', $id)->get(); 
    $otherbyPercentage = otherBenifitsbyPercentage::where('user_id', $id)->get(); 
    
    
    return view('AdminLTE/frontend/Users/edit_user_profile', [
        'user_data' => $user_data,
        'academic' => $academic,
        'UsersProfessionalCertificate' => $UsersProfessionalCertificate,
        'UsersChildInfo' => $UsersChildInfo,
        'JobExpriences' => $JobExpriences,
        'extra_benifits' => $extra_benifits,
        'otherbyPercentage' => $otherbyPercentage,
    
    ]);
}


// Redirect or respond accordingly// Redirect or respond accordingly// Redirect or respond accordingly// Redirect or respond accordingly
// In your controller
public function update_users(Request $request, $id)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
        'name' => 'required|string|max:255',
        'designation' => 'required|string',
        'address' => 'required|string',
        'department_name' => 'required|string',
        'otithee_joining_date' => 'required|date',
        'blood_group' => 'sometimes|string',
        'nationality_country' => 'required|string',
        'DOB' => 'required|date',
        'pay_frequency' => 'required|string',
        'bonus_information' => 'required|string',
   

         // Add other validation rules for user fields ##FOREACH START NEEDYAMIN
         //======> degree
        'degree_information.*' => 'sometimes|string',
        'degree.*' => 'sometimes|string',
        'joining_year.*' => 'sometimes|date',
        'passing_year.*' => 'sometimes|date',


        // Add other validation rules for academic fields ##FOREACH END NEEDYAMIN
        'nid_Information' => 'required|string',
        'gender' => 'required|string',
        'phoneCountry' => 'required|string',

        'profile_pic' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($id),
        ],
        'curriculum_vita_cv' => 'sometimes|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:50240',
        
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
    # Set user attributes from the request data
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
    $user->medical_history=$request->input('medical_history');
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



    if ($request->has('degree_information') && !empty($request->input('degree_information'))) {
        // Delete old academic records associated with the user
        Academic::where('user_id', $lastInsertID)->delete();
    
        // Loop through the new academic data and associate it with the user
        foreach ($request->input('degree_information') as $key => $degreeInformation) {
            // Check if 'degree_information' is not empty
            if (!empty($degreeInformation)) {
                Academic::create([
                    'degree_information' => $degreeInformation,
                    'degree' => $request->input('degree')[$key],
                    'join_year' => $request->input('joining_year')[$key],
                    'pass_year' => $request->input('passing_year')[$key],
                    'user_id' => $lastInsertID,
                ]);
            }
        }
    }

    
     if ($request->has('cert_name') && !empty($request->input('cert_name'))) {
    // Delete old professional certificate records associated with the user
    UsersProfessionalCertificate::where('user_id', $lastInsertID)->delete();

    // Loop through the new professional certificate data and associate it with the user
    foreach ($request->input('cert_name') as $key => $professionalInformation) {
        // Check if 'cert_name' is not empty before creating the record
        if (!empty($professionalInformation)) {
            UsersProfessionalCertificate::create([
                'certificate_name' => $professionalInformation,
                'organization_name' => $request->input('cert_org_name')[$key],
                'start_date' => $request->input('cert_start_date')[$key],
                'end_date' => $request->input('cert_end_date')[$key],
                'user_id' => $lastInsertID,
            ]);
        }
    }
}

    
    
if ($request->has('job_designation_name') && !empty($request->input('job_designation_name'))) {
    // Delete old job experiences records associated with the user
    JobExpriences::where('user_id', $lastInsertID)->delete();

    // Loop through the new job experiences data and associate it with the user
    foreach ($request->input('job_designation_name') as $key => $JobExpriencesformation) {
        // Check if 'job_designation_name' is not empty before creating the record
        if (!empty($JobExpriencesformation)) {
            JobExpriences::create([
                'job_designation_name' => $JobExpriencesformation,
                'job_org_name' => $request->input('job_org_name')[$key],
                'job_start_date' => $request->input('job_start_date')[$key],
                'job_end_date' => $request->input('job_end_date')[$key],
                'user_id' => $lastInsertID,
            ]);
        }
    }
}

    
    
if ($request->has('child_name') && !empty($request->input('child_name'))) {
    UsersChildInfo::where('user_id', $lastInsertID)->delete();

    // Loop through the new child information data and associate it with the user
    foreach ($request->input('child_name') as $key => $professonalformation) {
        // Check if 'child_name' is not empty before creating the record
        if (!empty($professonalformation)) {
            UsersChildInfo::create([
                'child_name' => $professonalformation,
                'child_gender' => $request->input('child_gender')[$key],
                'child_birthday' => $request->input('child_birthday')[$key],
                'user_id' => $lastInsertID,
            ]);
        }
    }
}


if ($request->has('benifits_name') && !empty($request->input('benifits_name'))) {
    // Delete old child information records associated with the user
    extra_benifits::where('user_id', $lastInsertID)->delete();

    // Loop through the new child information data and associate it with the user
    foreach ($request->input('benifits_name') as $key => $professonalformationbenifits_name) {
        if (!empty($professonalformationbenifits_name)) {
            extra_benifits::create([
                'benifits_name' => $professonalformationbenifits_name,
                'benifits_amount' => $request->input('benifits_amount')[$key],
                'user_id' => $lastInsertID,
            ]);
        }
    }
}


### otherBenifitsbyPercentage
if ($request->has('other_benifits_name') && !empty($request->input('other_benifits_name'))) {
    // Delete old child information records associated with the user
    otherBenifitsbyPercentage::where('user_id', $lastInsertID)->delete();

    // Loop through the new child information data and associate it with the user
    foreach ($request->input('other_benifits_name') as $key => $professonalformationbenifits_name) {
        if (!empty($professonalformationbenifits_name)) {
            otherBenifitsbyPercentage::create([
                'other_benifits_name' => $professonalformationbenifits_name,
                'other_benifits_by_percentage' => $request->input('other_benifits_by_percentage')[$key],
                'user_id' => $lastInsertID,
            ]);
        }
    }
}



    // Redirect or respond accordingly
    return redirect()->route('users_home')->with('success', '`' . $user->name = $request->input('name') .'` Information Successfully Updated');
}



public function destroy($id)
{
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
    
    $item->delete();
    return redirect()->route('users_home')->with('success', '`'. $item->name . '` has been deleted!');

}


}


