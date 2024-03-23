<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use Carbon\Carbon;
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
use App\Models\notice;
use App\Models\holiday;
use App\Models\LeaveApplication;
use App\Models\department;


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

  
    // Exclude users based on email or phone number
    $query->where(function ($query) {
        $query->where('email', '!=', 'needyamin@gmail.com')
              ->orWhere('phone_number', '!=', '01878578504');
    });

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



// Function to handle user login
public function login(Request $request) {
    // Validate request data
    $validator = Validator::make($request->all(), [
        //'email' => 'required|email', // Validation rule for email
        'password' => 'required|string|min:6', // Validation rule for password
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Attempt to authenticate the user
    if (!Auth::attempt($request->only('email', 'phone_number', 'password'))) {
        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    // Get the authenticated user
    $user = $request->user();

    // Create a new token for this user
    $token = $user->createToken('authToken')->plainTextToken;

    // Retrieve roles for the user
    $roles = Role::all();
    $role_user = Role::select('user_id', $user->id);
    $main_role = Role::find($user->id);

    // Determine main role name
    $main_role_name = $main_role ? $main_role->name : null;

    // Return user data and token as JSON
    return response()->json([
        'user' => $user, 
        'token' => $token,
        'status' => 'login success',
        'main_role_name' => $main_role_name,
    ]);
}





# Function to handle user logout
public function logout(Request $request){
  $request->user()->tokens()->delete();
   return response()->json(['message' => 'Logged out']);
}


#GET /api/dashboard
public function dashobard(){
    // Get today's date
    $today = Carbon::now();

    // Calculate the date 7 days from today
    $sevenDaysLater = $today->copy()->addDays(7);

    // Fetch users with upcoming birthdays in the next 7 days
    $upcomingBirthdays = reg_user::with(['child_info' => function ($query) use ($today, $sevenDaysLater) {
        $query->whereBetween('child_birthday', [$today, $sevenDaysLater]);
    }])->whereBetween('DOB', [$today, $sevenDaysLater])->get();

    $userChildBirthday = UsersChildInfo::whereDay('child_birthday', $today->day)
                                        ->whereMonth('child_birthday', $today->month)->get();
    
    $usersDOB = reg_user::whereDay('DOB', $today->day)->whereMonth('DOB', $today->month)->get();
    
    $userChild = reg_user::with(['child_info' => function ($query) use ($today) {
        $query->whereDate('child_birthday', $today);
    }])->get();
    
    $usersAnniversary = reg_user::whereDay('spouse_anniversary', $today->day)
                                ->whereMonth('spouse_anniversary', $today->month)->get();

    $holiday = holiday::whereDay('start_date', $today->day)->whereMonth('start_date', $today->month)->get();

    $allNotice = notice::latest()->get();
    
    $allLeave = LeaveApplication::latest()->get();

    // Fetch LeaveApplications with upcoming events within the next 7 days
    $upcomingLeave = LeaveApplication::whereBetween('application_start_date', [$today, $sevenDaysLater])
                                     ->orWhereBetween('application_end_date', [$today, $sevenDaysLater])
                                     ->get();

    $usersCount = reg_user::count();
    $departmentCount = department::count();
    $leaveApplicationCount = LeaveApplication::count();
    $noticeCount = notice::count();

    // Prepare the data to be returned as JSON
    $data = [
        'users_count' => $usersCount,
        'department_count' => $departmentCount, 
        'users_DOB' => $usersDOB,
        'user_child_birthday' => $userChildBirthday,
        'user_child' =>  $userChild,
        'users_anniversary' =>  $usersAnniversary,
        'upcomingBirthdays' => $upcomingBirthdays,
        'all_notice' => $allNotice,
        'all_leave' =>  $allLeave,
        'notice_count' => $noticeCount,
        'leave_application_count' => $leaveApplicationCount,
        'upcoming_leave' => $upcomingLeave,
        'holiday' => $holiday,
    ];


    // Check each data field and replace with "No content found" if empty
    foreach ($data as $key => $value) {
        if (is_array($value) && count($value) === 0) {
            $data[$key] = 'No content found';
        }
    }

    // Return the data as JSON response
    return response()->json($data);


}


# GET /api/employees?per_page=10&page=1
public function get_employees(Request $request){
    $perPage = $request->query('per_page', 10);
    $page = $request->query('page', 1);

    // Assuming 'reg_users' is your employees table
    $users = reg_user::paginate($perPage, ['*'], 'page', $page);

    // Check if any users are found
    if ($users->isEmpty()) {
        return response()->json(['error' => 'Users not found'], 404);
    }
    // Return paginated users
    return response()->json(['users' => $users], 200);
}



public function get_employees_profile(Request $request, $number){
  $user = reg_user::with('child_info', 'academicRecords', 'professional_certificate', 'job_expriences')
  ->where('phone_number', $number)->first();

if (!$user) {
  return response()->json(['error' => 'User not found'], 404);
}
return response()->json(['user' => $user], 200);

}


# GET /api/employees_search?search=john&page=1&per_page=10
public function search_get_employees(Request $request){
    $perPage = $request->query('per_page', 10);
    $page = $request->query('page', 1);
    $search = $request->query('search'); 

    $query = reg_user::query();

    if ($search) {
        $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%'); 
    }

    $users = $query->paginate($perPage, ['*'], 'page', $page);

    if ($users->isEmpty()) {
        return response()->json(['error' => 'Users not found'], 404);
    }

    // Return paginated users
    return response()->json(['users' => $users], 200);
}



# GET /api/notice?per_page=10&page=1
public function all_notice(Request $request){
    $perPage = $request->query('per_page', 10);
    $page = $request->query('page', 1);

    $notice = notice::paginate($perPage, ['*'], 'page', $page);

    // Check if any users are found
    if ($notice->isEmpty()) {
        return response()->json(['error' => 'Notices not found'], 404);
    }
    // Return paginated users
    return response()->json(['notice' => $notice], 200);
}


# GET /api/department?per_page=10&page=1
public function all_department(Request $request){
    $perPage = $request->query('per_page', 10);
    $page = $request->query('page', 1);

    $department = department::paginate($perPage, ['*'], 'page', $page);

    // Check if any users are found
    if ($department->isEmpty()) {
        return response()->json(['error' => 'Department not found'], 404);
    }
    // Return paginated users
    return response()->json(['department' => $department], 200);
}



# GET /api/leave_application?user_id=123&per_page=10&page=1
public function leave_applications(Request $request) {
    // Define validation rules for the search parameters
    $validator = Validator::make($request->all(), [
        'user_id' => 'integer|exists:users,id', // Ensure user_id is an integer and exists in the users table
        'per_page' => 'integer',
        'page' => 'integer',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Extract search parameters from the request
    $userId = $request->input('user_id', auth()->id()); 
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);

    // Retrieve leave applications based on the provided user ID
    $applications = LeaveApplication::where('user_id', $userId)
                                    ->paginate($perPage, ['*'], 'page', $page);

    // Check if any leave applications are found
    if ($applications->isEmpty()) {
        return response()->json(['error' => 'Leave applications not found for the specified user'], 404);
    }

    // Return paginated leave applications
    return response()->json(['applications' => $applications], 200);
}





# POST /api/submit_leave_applications
/*
    "application_type": "Sick leave",
    "application_message": "I just want",
    "application_start_date": "2024-03-19",
    "application_end_date": "2024-03-19"
*/

public function submit_leave_applications(Request $request)
{
    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'application_type' => 'required|string',
        'application_message' => 'required|string',
        'application_start_date' => 'required|date',
        'application_end_date' => 'required|date',
        // Add more validation rules as needed
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Create the leave application record
    $leaveApplication = LeaveApplication::create([
        'user_id' => auth()->id(),
        'application_type' => $request->input('application_type'),
        'application_message' => $request->input('application_message'),
        'application_start_date' => $request->input('application_start_date'),
        'application_end_date' => $request->input('application_end_date'),
        // Add more fields here if needed
    ]);

    // Return success response with the newly created leave application
    return response()->json(['message' => 'Leave application created successfully', 'data' => $leaveApplication], 201);
}




}
