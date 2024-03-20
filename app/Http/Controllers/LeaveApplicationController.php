<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LeaveApplicationController extends Controller
{

    public function index()
    {   $id = Auth::id();
        $application = LeaveApplication::where('user_id', $id)->get();
        return view('AdminLTE/frontend/leave_application/leave_appliation_dashboard',['application' => $application]);
    }


    public function create()
    {  
        return view('AdminLTE/frontend/leave_application/leave_application_create');
    }

    public function store(Request $request)
    {
         // Instantiate a new LeaveApplication model
        $leaveApplication = new LeaveApplication();

          // Assign values to the properties
         $leaveApplication->application_type = $request->input('application_type');
         $leaveApplication->application_message = $request->input('application_message');
         $leaveApplication->application_start_date = $request->input('application_start_date');
         $leaveApplication->application_end_date = $request->input('application_end_date');
         $leaveApplication->user_id = Auth::id();
         $leaveApplication->approved_user_id = 0;
         // Save the leave application to the database
         $leaveApplication->save();

         return redirect()->route('application_home')->with('success', 'Leave application submitted successfully!');
    }


    public function edit(Request $request, $id)
    {
        $leave= LeaveApplication::find($id);
        return view('AdminLTE/frontend/leave_application/leave_application_edit',['leave' => $leave]);
    }


    public function update(Request $request)
    {
         $id=$request->input('leave_id') ;
         $leave = LeaveApplication::find($id);
         $leave->application_type = $request->input('application_type');
         $leave->application_message = $request->input('application_message');
         $leave->application_start_date = $request->input('application_start_date');
         $leave->application_end_date = $request->input('application_end_date');
         $leave->status = $request->input('status') ?  $request->input('status') : '0';
         $leave->approved_user_id = Auth::id();
         $leave->update();
         return redirect()->route('application_home')->with('success', 'Leave application updated successfully!');
        
    }


    public function destroy($id)
    {
        $item = LeaveApplication::find($id);
        
        if (!$item) {
            return redirect()->route('application_home')->with('error', 'Item not found!');
        }

        $item->delete();
        return redirect()->route('application_home')->with('success', 'Item deleted successfully!');

    }
}
