<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class LeaveApplicationController extends Controller{

    public function index(){   
        $id = Auth::id();
        $application = LeaveApplication::where('user_id', $id)->get();
        return view('AdminLTE/frontend/leave_application/leave_appliation_dashboard',['application' => $application]);
    }


    public function leave_application_view(Request $request, $view){
    $application = LeaveApplication::where('status', $view)->get();
        return view('AdminLTE/frontend/leave_application/view',
        [
            'application' => $application,
    ]);
    }

    #########################
    public function delay_office(Request $request, $delay_office){
        $application = LeaveApplication::where('application_type', $delay_office)->get();
            return view('AdminLTE/frontend/leave_application/view',
            [
                'application' => $application,
        ]);
        }


    public function create(){   
       $id = Auth::id();
       $leave_status = LeaveApplication::where('user_id', $id)->whereIn('status', [0, 4])->get();
        return view('AdminLTE/frontend/leave_application/leave_application_create',[
            'leave_status' => $leave_status,
        ]);
    }

    public function delay_office_application(){
        $id = Auth::id();
        $leave_status = LeaveApplication::where('user_id', $id)->whereIn('status', [0, 4])->get();
         return view('AdminLTE/frontend/leave_application/delay_office_application',[
             'leave_status' => $leave_status,
         ]);
    }


    public function store(Request $request){
       ## Validate the request data
       $leaveApplication = $request->validate([
        'file_applications' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2000',
     ]);

        $leaveApplication = new LeaveApplication();
         $leaveApplication->application_type = $request->input('application_type');
         $leaveApplication->application_message = $request->input('application_message');
         $leaveApplication->application_start_date = $request->input('application_start_date');
         $leaveApplication->application_end_date = $request->input('application_end_date');
          
         ## file
         $file = $request->file('file_applications');
         if ($request->hasfile('file_applications')) {
           $extension = $file->getClientOriginalExtension();
           $currentTime = date('Ymd_His');
           $leave_file_name = Auth::user()->phone_number . '-time-' . $currentTime . '-file.' . $extension;
           $file->move('assets/leave/', $leave_file_name);
           $leaveApplication->file_applications = $leave_file_name;
         }

         $leaveApplication->user_id = Auth::id();
         $leaveApplication->approved_user_id = 0;
         $leaveApplication->save();
         return redirect()->route('application_home')->with('success', 'Leave application submitted successfully!');
    }


    public function edit(Request $request, $id){
        $leave= LeaveApplication::find($id);
        return view('AdminLTE/frontend/leave_application/leave_application_edit',['leave' => $leave]);
    }


    public function update(Request $request){
         $id=$request->input('leave_id') ;
         $leave = LeaveApplication::find($id);
         $leave->application_type = $request->input('application_type');
         $leave->application_message = $request->input('application_message');
         $leave->application_start_date = $request->input('application_start_date');
         $leave->application_end_date = $request->input('application_end_date');
         ## file
          $file = $request->file('file_applications');
          if ($request->hasfile('file_applications')) {
            $extension = $file->getClientOriginalExtension();
            $currentTime = date('Ymd_His');
            $leave_file_name = Auth::user()->phone_number .'-time-'. $currentTime . '-file.' . $extension;
            $file->move('assets/leave/', $leave_file_name);
            $leave->file_applications = $leave_file_name;
          }

         $leave->status = $request->input('status') ?  $request->input('status') : '0';
         $leave->approved_user_id = Auth::id();
         $leave->update();
         return redirect()->route('application_home')->with('success', 'Leave application updated successfully!');
        
    }


    public function destroy($id){
        $item = LeaveApplication::find($id);
        
        if (!$item) {
            return redirect()->route('application_home')->with('error', 'Item not found!');
        }

        $destination = public_path('assets/leave/') . $item->file_applications;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $item->delete();
        return redirect()->route('application_home')->with('success', 'Item deleted successfully!');

    }
}
