<?php

namespace App\Http\Controllers;
use App\Models\reg_user;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    
    ##########  AjaxDataTable  ##########
    public function AjaxDataTable(){
        $users = reg_user::get()->all();
        return view('AdminLTE/frontend/Search/AjaxDataTable',['users' => $users]);
    }

    public function activitylogs()
    {
       $logs = ActivityLog::orderBy('created_at', 'desc')->get();
       return view('AdminLTE/frontend/activitylogs/index',['logs' => $logs]);
    }


    public function profile(Request $request, $number)
    {
        $user = reg_user::with('child_info', 'academicRecords', 'professional_certificate', 'job_expriences', 'otherBenifitsbyPercentage', 'extra_benifits')->where('phone_number', $number)->firstOrFail();
    
        return view('AdminLTE/frontend/Search/employee_profile', compact('user'));
    }
    


    public function employee()
    {
        $users = reg_user::get()->all();
        # return $user=reg_user::get()->all();
        return view('AdminLTE/frontend/Search/AjaxDataTable',['users' => $users]);
    }


}
