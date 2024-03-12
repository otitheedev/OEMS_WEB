<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use App\Models\User; 
use App\Models\reg_user;
use App\Models\Academic;
use App\Models\UsersProfessionalCertificate;
use App\Models\JobExpriences;
use App\Models\UsersChildInfo;

## role user
use App\Models\Role;
use App\Models\Permission;

# Define AuthController class which extends Controller
class AuthController extends Controller
{
    
    ######################## API getAjaxDataTable All_Users_Index ##########################
    public function getAjaxDataTable(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value', '');
        $orderColumn = $request->input('order.0.column', 0);
        $orderDirection = $request->input('order.0.dir', 'asc');
        $dateRange = $request->input('dateRange', []);
    
        $query = reg_user::query();
    
        // Apply search filter
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                      ->orWhere('email', 'like', '%' . $searchValue . '%')
                      ->orWhere('department_name', 'like', '%' . $searchValue . '%')
                      ->orWhere('phone_number', 'like', '%' . $searchValue . '%')
                      ->orWhere('designation', 'like', '%' . $searchValue . '%')
                      ->orWhere('gender', 'like', '%' . $searchValue . '%');
                // Add more columns as needed for search
            });
        }
    
        // Apply date range filter
        if (!empty($dateRange)) {
            $startDate = $dateRange[0];
            $endDate = $dateRange[1];
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        // Get total records without filters
        $totalRecordsWithoutFilters = reg_user::count();
    
        // Apply sorting
        $orderColumnName = $request->input("columns.$orderColumn.data", 'id');
        $query->orderBy($orderColumnName, $orderDirection);
    
        // Apply pagination
        $data = $query->offset($start)->limit($length)->get();
    
        // Get total records with filters
        $totalRecords = $query->count();
    
        return response()->json([
            'data' => $data,
            'recordsTotal' => $totalRecordsWithoutFilters,
            'recordsFiltered' => $totalRecords,
        ]);
    }
 ######################################################



# Function to handle user registration
public function create_users(Request $request)
{
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
        'degree_information.*' => 'required|string',
        'degree.*' => 'required|string',
        'joining_year.*' => 'sometimes|date',
        'passing_year.*' => 'required|date',
        'nid_Information' => 'required|string',
        'gender' => 'required|string',
        'phoneCountry' => 'required|string',
        'phone_number' => 'required|string|unique:users,phone_number',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $user = new reg_user();
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
    $user->mobile_bill = $request->input('mobile_bill');
    $user->bonus_information = $request->input('bonus_information');
    $user->extra_benefits = $request->input('extra_benefits');
    $user->nid_Information = $request->input('nid_Information');
    $user->language = $request->input('language');
    $user->gender = $request->input('gender');
    $user->marital_status = $request->input('marital_status');
    $user->spouse_name = $request->input('spouse_name');
    $user->spouse_birthday = $request->input('spouse_birthday');
    $user->spouse_nid = $request->input('spouse_nid');
    $user->spouse_anniversary = $request->input('spouse_anniversary');
    $user->medical_history = $request->input('medical_history');
    $user->hobbies_and_interest = $request->input('hobbies_and_interest');
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

    $image1 = $request->file('profile_pic');
    if ($request->hasfile('profile_pic')) {
        $extension = $image1->getClientOriginalExtension();
        $department_image_name = $user->name . '-phone_number-.' . $extension;
        $image1->move('assets/users/', $department_image_name);
        $user->profile_pic = $department_image_name;
    }

    $CV = $request->file('curriculum_vita_cv');
    if ($request->hasfile('curriculum_vita_cv')) {
        $extension = $CV->getClientOriginalExtension();
        $UserCV = $user->phone_number . '-CV-.' . $extension;
        $CV->move('assets/users/UserCV/', $UserCV);
        $user->curriculum_vita_cv = $UserCV;
    }

    $user->save();
    $lastInsertID = $user->id;

    if ($request->has('degree_information') && !empty($request->input('degree_information'))) {
        foreach ($request->input('degree_information') as $key => $degreeInformation) {
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
        foreach ($request->input('job_designation_name') as $key => $JobExpriencesformation) {
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
        foreach ($request->input('child_name') as $key => $professonalformation) {
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
    return response()->json(['message' => 'User created successfully', 'user_id' => $lastInsertID], 201);
}


 
public function get_employees(Request $request, $number){
  $user = reg_user::with('child_info', 'academicRecords', 'professional_certificate', 'job_expriences')
  ->where('phone_number', $number)->first();

if (!$user) {
  return response()->json(['error' => 'User not found'], 404);
}
return response()->json(['user' => $user], 200);

}



// Function to handle user login
public function login(Request $request){
$validator = Validator::make($request->all(), [
'email' => '', 
'password' => 'required|string|min:6', 
]);

if ($validator->fails()) {
  return response()->json(['error' => $validator->errors()], 400);
}

if (!Auth::attempt($request->only('phone_number', 'password'))) {
return response()->json(['message' => 'Invalid login credientials'], 401);
}

$user = $request->user(); # If credentials are valid, get the authenticated user
$token = $user->createToken('authToken')->plainTextToken; # Create a new token for this user
$roles = Role::all();
$role_user = Role::select('user_id',$user->id);
$main_role = Role::find($user->id);

if ($main_role) {$main_role_name = $main_role->name;} else {$main_role_name = null; }

# Return user data and token as JSON
return response()->json([
    'user' => $user, 
    'token' => $token,
    'status' => 'login success',
    'main_role_name' =>$main_role_name,
]);
}

 # Function to handle user logout
public function logout(Request $request){
  # Delete all tokens for the authenticated user
  $request->user()->tokens()->delete();
   # Return success message as JSON
   return response()->json(['message' => 'Logged out']);
}
}
