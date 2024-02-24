<?php

namespace App\Http\Controllers;
use App\Models\reg_user;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    
   #####################  AjaxDataTable
    public function AjaxDataTable(){
        $users = reg_user::get()->all();
        return view('AdminLTE/frontend/Search/AjaxDataTable',['users' => $users]);
    }


    public function profile(Request $request, $number)
    {
         
         $user = reg_user::with('child_info','academicRecords', 'professional_certificate', 'job_expriences','otherBenifitsbyPercentage','extra_benifits')->where('phone_number',$number)->first();
         if (!$user){abort(404);}
         $child_info = $user->child_info;
         $academicRecords = $user->academicRecords;
         $professional_certificate = $user->professional_certificate;
         $job_expriences = $user->job_expriences;
         $extra_benifits = $user->extra_benifits;
         $otherBenifitsbyPercentage = $user->otherBenifitsbyPercentage;

         return view('AdminLTE/frontend/Search/employee_profile',[
            'user' => $user, 
            'child_info' => $child_info,
            'academicRecords'=> $academicRecords,
            'professional_certificate' => $professional_certificate,
            'job_expriences' => $job_expriences,
            'extra_benifits' => $extra_benifits,
            'otherBenifitsbyPercentage' => $otherBenifitsbyPercentage,
        ]);
        
        # return $user->academicRecords[0]->id;
        # return $user=reg_user::get()->all();
        # Access the academic_records array
        # Loop through each academic record and print pass_year
        # foreach ($academicRecords as $record) {
        # $passYear = $record->pass_year;
        # echo "Pass Year: $passYear<br>";
        # }

    }


    public function employee()
    {
        $users = reg_user::get()->all();
        # return $user=reg_user::get()->all();
        return view('AdminLTE/frontend/Search/AjaxDataTable',['users' => $users]);
    }

}
