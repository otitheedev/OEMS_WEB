<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\adminRole\adminRole;
use App\Models\adminRole\adminUserRole;
use App\Models\department;
use App\Models\reg_user;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

##SMS
use Xenon\LaravelBDSms\Provider\BulkSmsBD;
use Xenon\LaravelBDSms\Sender;


class AdminController extends Controller
{

public function admin_dashboard(){
 // Get today's date
 $today = Carbon::now();
 
 $users_DOB= reg_user::whereDay('DOB', $today->day)->whereMonth('DOB', $today->month)->get();
 $users_count= reg_user::count();
 $department_count= department::count();
       return view('AdminLTE/admin_dashboard',[
           'users_count' => $users_count,
           'department_count' => $department_count, 
           'users_DOB' => $users_DOB,
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

/*     $sender = Sender::getInstance();
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





    public function home()
    {
        $adminRole=adminRole::all();
        return view('AdminLTE/frontend/adminRole/index',['adminRole' => $adminRole]);
    }

    public function create()
    {
        return view('AdminLTE/frontend/adminRole/addRole');
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
        ]);

        if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
          }

        adminRole::create([
            'name' => $request->input('name'),
        ]);
       
        $adminRole=adminRole::all();
        return redirect()->route('addRole_admin_home')->with('success', 'New Role has been added successfully');

    }


    public function addRole(Request $request, $id)
    {
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

    public function destroy(Request $request, $id)
    {
        $item = adminRole::find($id);
        
        if (!$item) {
            return redirect()->route('addRole_admin_home')->with('error', 'Item not found!');
        }
        $item->delete();
        return redirect()->route('addRole_admin_home')->with('success', 'Item deleted successfully!');

    }

    }

