<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\adminRole\adminRole;
use App\Models\adminRole\adminUserRole;
use App\Models\department;
use App\Models\UsersChildInfo;
use App\Models\reg_user;
use App\Models\notice;
use App\Models\holiday;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

##SMS
use Xenon\LaravelBDSms\Provider\BulkSmsBD;
use Xenon\LaravelBDSms\Sender;


class AdminController extends Controller{

public function admin_dashboard(){

# Get today's date
$today = Carbon::now();
# Calculate the date 7 days from today
$sevenDaysLater = $today->copy()->addDays(7);

# Fetch users with upcoming birthdays in the next 7 days
$upcomingBirthdays = reg_user::with(['child_info' => function ($query) use ($today, $sevenDaysLater) {
$query->whereBetween('child_birthday', [$today, $sevenDaysLater]);}])->whereBetween('DOB', [$today, $sevenDaysLater])->get();

$user_child_birthday = UsersChildInfo::whereDay('child_birthday', $today->day)->whereMonth('child_birthday', $today->month)->get();
$users_DOB= reg_user::whereDay('DOB', $today->day)->whereMonth('DOB', $today->month)->get();
$user_child = reg_user::with(['child_info' => function ($query) use ($today) {$query->whereDate('child_birthday', $today);}])->get();
$users_anniversary= reg_user::whereDay('spouse_anniversary', $today->day)->whereMonth('spouse_anniversary', $today->month)->get();

##
$holiday= holiday::whereDay('start_date', $today->day)->whereMonth('start_date', $today->month)->get();
$all_holiday= holiday::whereMonth('start_date', $today->month)->get();
$all_notice= notice::latest()->paginate(20);
$all_leave= LeaveApplication::latest()->paginate(20);

// Fetch LeaveApplications with upcoming events within the next 7 days
$upcomingLeave = LeaveApplication::where(function($query) use ($today, $sevenDaysLater) {
    $query->whereBetween('application_start_date', [$today, $sevenDaysLater])
          ->orWhereBetween('application_end_date', [$today, $sevenDaysLater]);
})->get();


 $users_count= reg_user::count();
 $department_count= department::count();
 $LeaveApplication_count= LeaveApplication::count();
 $notice_count= notice::count();

 # leave status
 $pending = LeaveApplication::where('status', 0)->count();
 $approve = LeaveApplication::where('status', 1)->count();
 $rejected = LeaveApplication::where('status', 2)->count();
 $contact_hr = LeaveApplication::where('status', 3)->count();
 $delay_office = LeaveApplication::where('application_type', 'Delay Office')->count();
 
 # Attendance & Salary calculation start
 $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
 $lastDayOfMonth = Carbon::now()->endOfMonth()->toDateString();
 $userId = Auth::user()->attendance_uid;
 $attendances = Attendance::select('uid')
 ->selectRaw("$userId as user_id")
 ->where('userid', $userId) 
 ->whereBetween(DB::raw('DATE(timestamp)'), [$firstDayOfMonth, $lastDayOfMonth])
 ->distinct(DB::raw('DATE(timestamp)'))
 ->count();
$normal_salary = Auth::user()->normal_salary;
$totalAmount =  $normal_salary * $attendances;
 # Attendance & Salary calculation end
 
  return view('AdminLTE/admin_dashboard',[
           'users_count' => $users_count,
           'department_count' => $department_count, 
           'users_DOB' => $users_DOB,
           'user_child_birthday' => $user_child_birthday,
           'user_child' =>  $user_child,
           'users_anniversary' =>  $users_anniversary,
           'upcomingBirthdays' => $upcomingBirthdays,
           'all_notice' => $all_notice,
           'all_leave' =>  $all_leave,
           'notice_count' => $notice_count,
           'LeaveApplication_count' => $LeaveApplication_count,
           'upcomingLeave' => $upcomingLeave,
           'holiday' => $holiday,
           'all_holiday' => $all_holiday,
           'pending' => $pending,
           'approve' => $approve,
           'rejected' => $rejected,
           'contact_hr' => $contact_hr,
           'attendances' =>  $attendances,
           'totalAmount' => $totalAmount,
           'delay_office' => $delay_office,
       ]);
   }



########## SND SMS START ################    
public function sms(Request $request){
    
    $validator = Validator::make($request->all(), [
        'phone_number' => 'required|string|max:15',
        'message' => 'required|string|max:100',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withInput()->withErrors($validator);
    }
    //return $request;
    $mobile = $request->input('phone_number');
    $message = $request->input('message');
    
    // Accessing values using env function
    $apiKey = env('SMS_API_KEY');
    $type = env('SMS_TYPE');
    $senderId = env('SMS_SENDER_ID');

    # SMS
    $sender = Sender::getInstance();
    $sender->setProvider(BulkSmsBD::class);
    $sender->setMobile($mobile);
    $sender->setMessage($message);
    $sender->setQueue(true); 
    $sender->setConfig(
   [
     'api_key' => $apiKey,
     'type' => $type,
     'senderid' => $senderId,
   ]
   );
    $status = $sender->send(); 
    return view('AdminLTE/frontend/SMS/createSMS')->with('success', 'Message Sent successfully');
}
########## SND SMS END ################   


public function createSMS(Request $request){

   /*  
    $sender = Sender::getInstance();
    $sender->setProvider(BulkSmsBD::class);
    $sender->setMobile('01878578504');
    $sender->setMessage('This is test message from OEMS');
    $sender->setQueue(true); 
    $sender->setConfig(
       [
       'api_key' => 'qfI5bCOCc04w4812MUv4',
       'type' => 'text',
       'senderid' => '8809617615488',
        ]
   );

    $status = $sender->send(); */
    return view('AdminLTE/frontend/SMS/createSMS');
}


    public function home(){
        $adminRole=adminRole::all();
        return view('AdminLTE/frontend/adminRole/index',['adminRole' => $adminRole]);
    }

    public function create(){
        return view('AdminLTE/frontend/adminRole/addRole');
    }


    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    adminRole::create(['name' => $request->input('name'),]);
    $adminRole=adminRole::all();
        return redirect()->route('addRole_admin_home')->with('success', 'New Role has been added successfully');
    }


    public function addRole(Request $request, $id){
        $adminRole=adminRole::find($id);
        $users=reg_user::all();
        return view('AdminLTE/frontend/adminRole/addRole',
        [
            'adminRole' => $adminRole,
            'users' => $users,
        ]);

    }

  
 
    public function addRoleUpdate(Request $request){
        //return $request;
        adminUserRole::create([
            'user_id' => $request->input('role_users_id'),
            'role_id' => $request->input('role_id'),
        ]);
       
        return redirect()->route('addRole_admin_home')->with('success', 'New Role has been added successfully');


    }

    public function destroy(Request $request, $id){
        $item = adminRole::find($id);
        if (!$item) {
            return redirect()->route('addRole_admin_home')->with('error', 'Item not found!');
        }
        $item->delete();
        return redirect()->route('addRole_admin_home')->with('success', 'Item deleted successfully!');
    }

    }

