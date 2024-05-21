<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;

use App\Models\Models\Attendance;
use App\Models\Models\AttendanceUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  ## attendance get all from mysql (attendance_mySQL)
  public function attendance_mySQL(){
      # Get the first and last day of the current month
      $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
      $lastDayOfMonth = Carbon::now()->endOfMonth()->toDateString();
      $attendances = Attendance::whereBetween('timestamp', [$firstDayOfMonth, $lastDayOfMonth])->orderByDesc('timestamp')->get();
      $coloredRecords = [];
      foreach ($attendances as $attendance) {
          $checkInTime = strtotime($attendance['timestamp']);
          $checkInHour = date('H', $checkInTime);
          $date = date('Y-m-d', $checkInTime);
          # Also, check if it's the first record for the current UID and date combination
          if ($attendance['type'] == 0 && ($checkInHour >= 10 && $checkInHour < 13) && !isset($coloredRecords[$attendance['uid']][$date])) {
              # Mark the current UID and date combination as colored
              $coloredRecords[$attendance['uid']][$date] = true;
              
              # Add additional attribute to the $attendance array to indicate that it needs to be colored
              $attendance['needs_color'] = true;
          } else {
              $attendance['needs_color'] = false;
          }
      }
      return view('AdminLTE.frontend.attendance.attendance_mysql', compact('attendances'));
  }

  # MY OWN ATTENDANCE, PLEASE CHANGE UID
  public function my_attendance_mysql(Request $request, $uid){
          if ($uid == auth()->user()->attendance_uid) {
          $firstDayOfMonth = Carbon::now()->startOfMonth()->toDateString();
          $lastDayOfMonth = Carbon::now()->endOfMonth()->toDateString();
          $attendances = Attendance::where('userid', $uid)->whereBetween('timestamp', [$firstDayOfMonth, $lastDayOfMonth])->orderByDesc('timestamp')->get();
          $coloredRecords = [];
          foreach ($attendances as $attendance) {
              $checkInTime = strtotime($attendance['timestamp']);
              $checkInHour = date('H', $checkInTime);
              $date = date('Y-m-d', $checkInTime);

              if ($attendance['type'] == 0 && ($checkInHour >= 10 && $checkInHour < 13) && !isset($coloredRecords[$attendance['uid']][$date])) {
                  $coloredRecords[$attendance['uid']][$date] = true;
                  $attendance['needs_color'] = true;
              } else {
                  $attendance['needs_color'] = false;
              }
            } 
          }

          else {
            abort(403, 'You are not authorized to see this page');
          }
          return view('AdminLTE.frontend.attendance.attendance_mysql', compact('attendances'));
  }

    # Direct get Device IP from Machine
    public function device_ip(){
        if (session()->exists('dip')) {
            $deviceip = session('dip');
        }
        else{
            session()->put('dip', '192.168.68.201');
            $deviceip = '192.168.68.201';
        }
        return $deviceip;
    }

    public function device_setip(Request $request){
        session()->put('dip', $request->deviceip);
        return redirect()->back();
    }
    
    public function index(){
        $deviceip = $this->device_ip();
        return view('AdminLTE.machine.welcome',compact('deviceip'));
    }

    public function test_sound(){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $zk->testVoice(); 
        return redirect()->back()->with('success_message','Playing sound on device.');
    }

    public function device_information(){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $deviceVersion = $zk->version();
        $deviceOSVersion = $zk->osVersion();
        $devicePlatform = $zk->platform();
        $devicefmVersion = $zk->fmVersion();
        $deviceworkCode = $zk->workCode();
        $devicessr = $zk->ssr();
        $devicepinWidth = $zk->pinWidth();
        $deviceserialNumber = $zk->serialNumber();
        $devicedeviceName = $zk->deviceName();
        $devicegetTime = $zk->getTime();
        return view('AdminLTE.machine.device-information',compact(
            'deviceip','deviceVersion','deviceOSVersion','devicePlatform','devicefmVersion','deviceworkCode',
            'devicessr','devicepinWidth','deviceserialNumber','devicedeviceName','devicegetTime',
        ));
    }

    public function device_data(){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $users = $zk->getUser();
        $attendaces = $zk->getAttendance();
        return view('AdminLTE.machine.device-data',compact(
            'deviceip','users','attendaces',
        ));
    }

    ####### All Attendances Direct Click to Show ####### 
    public function all_attendance(){
        #$deviceip = $this->device_ip();
        $zk = new ZKTeco('192.168.68.201',4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $users = $zk->getUser();
        $attendaces = $zk->getAttendance(); #limit 100;
        #$attendaces = $zk->getallAttendance();  #no limit
        return view('AdminLTE.frontend.attendance.attendance',compact(
            'users','attendaces',
        ));
    }

### attendance //attendance ### 
public function attendance_recoard(){
    $deviceip = $this->device_ip();
    $zk = new ZKTeco($deviceip,4370);
    $zk->connect(); 
    $zk->disableDevice();  
    $users = $zk->getUser();
    $attendaces = $zk->getAttendance();

    // return  $attendaces;
    // $today = Carbon::today();
    // $existingAttendance = Attendance::whereDate('timestamp', $today)->exists();
    // if ($existingAttendance) {
    // return redirect()->back()->with('success_message', 'Attendance records for today have already been processed.');
    // }

    // ## All attendances Create
    // foreach ($attendaces as $attendance) {
    //     Attendance::updateOrCreate([
    //         'uid' => $attendance['uid'], 
    //         'userid' => $attendance['id'],
    //         'state' => $attendance['state'],
    //         'timestamp' => $attendance['timestamp'],
    //         'type' => $attendance['type']
    //     ]);
    // }

    // ## All Users Create
    //  foreach ($users as $userData) {
    //      AttendanceUser::updateOrCreate([   
    //     'uid' => $userData['uid'],
    //     'userid' => $userData['userid'],
    //     'name' => $userData['name'],
    //     'role' => $userData['role'],
    //     'password' => $userData['password'],
    //     'cardno' => $userData['cardno'],
    //   ]);
    //  }

     // Insert data into the 'attendances' table in the second database
     foreach ($attendaces as $attendance) {
        DB::connection('spid3r_db')->table('attendances')->updateOrInsert([
            'uid' => $attendance['uid'], 
            'userid' => $attendance['id'],
            'state' => $attendance['state'],
            'timestamp' => $attendance['timestamp'],
            'type' => $attendance['type']
        ]);
    }
    // Insert data into the 'attendance_users' table in the second database
    foreach ($users as $userData) {
        DB::connection('spid3r_db')->table('attendance_users')->updateOrInsert([   
            'uid' => $userData['uid'],
            'userid' => $userData['userid'],
            'name' => $userData['name'],
            'role' => $userData['role'],
            'password' => $userData['password'],
            'cardno' => $userData['cardno'],
        ]);
    }
    return view('AdminLTE.machine.device-data',compact(
        'deviceip','users','attendaces',
    ));
   }

    public function device_data_clear_attendance(){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $zk->clearAttendance();

        return redirect()->back()->with('success_message','Attendance cleared successfully.');
    }

    public function device_restart(){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $zk->restart();
        return redirect()->back()->with('success_message','Device restart successfully.');
    }

    public function device_shutdown(){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $zk->shutdown();
        return redirect()->back();
    }

    public function device_adduser(){
        $deviceip = $this->device_ip();
        return view('AdminLTE.machine.device-adduser',compact('deviceip'));
    }

    public function device_setuser(Request $request){
       $deviceip = $this->device_ip();
       $uid = $request->uid;
       $userid = $request->userid;
       $name = $request->name;
       $role = (int)$request->role;
       $password = $request->password;
       $cardno = $request->cardno;
       //dd($request->role);
       $zk = new ZKTeco($deviceip,4370);
       $zk->connect(); 
       $zk->disableDevice();  
       $zk->setUser($uid , $userid , $name , $role , $password , $cardno);
       return redirect()->back()->with('success_message','User added to device successfully.');
    }

    public function device_removeuser_single($uid){
        $deviceip = $this->device_ip();
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $zk->disableDevice();  
        $zk->removeUser($uid);
        return redirect()->back()->with('success_message','User removed from device successfully.');
    }

    public function device_viewuser_single(Request $request){
        $deviceip = $this->device_ip();
        $uid = $request->uid;
        $userid = $request->userid;
        $name = $request->name;
        $role = (int)$request->role;
        $password = $request->password;
        $cardno = $request->cardno;
        $zk = new ZKTeco($deviceip,4370);
        $zk->connect(); 
        $userfingerprints=$zk->getFingerprint($request->uid);
        
        // foreach($userfingerprints as $userfingerprint)
        // {
        //     $imagearray= unpack("C*",$userfingerprint); 
        // }
        // $data = implode('', array_map(function($e) {
        //     return pack("C*", $e);
        // }, $$userfingerprint));
        // echo $data;
        // dd($data);
        
        //dd($userfingerprints);
        return view('AdminLTE.machine.device-information-user',compact(
            'deviceip','uid','userid','name',
            'role','password','cardno','userfingerprints',
        ));
    }
}
