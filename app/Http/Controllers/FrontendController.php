<?php

namespace App\Http\Controllers;
use App\Models\reg_user;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use DataTables;

class FrontendController extends Controller
{

    # GET TEMPLETE
    public function activitylogs(){
       return view('AdminLTE/frontend/activitylogs/index');
    }
    
    # AJAX HIT
    public function activitylogsAJAX(){
        $model = ActivityLog::query()->orderBy('created_at', 'desc');
        return DataTables::eloquent($model)->toJson();
    }
    
    public function profile(Request $request, $number){
        $user = reg_user::with('child_info', 'academicRecords', 'professional_certificate', 'job_expriences', 'otherBenifitsbyPercentage', 'extra_benifits','hobbies','medicalHistory')->where('phone_number', $number)->firstOrFail();
        return view('AdminLTE/frontend/Search/employee_profile', compact('user'));
    }

    public function employee(){
        $users = reg_user::get()->all();
        return view('AdminLTE/frontend/Search/AjaxDataTable',['users' => $users]);
    }


}
