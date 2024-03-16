<?php

namespace App\Http\Controllers;

use App\Models\notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {  
        $application = notice::all();
        return view('AdminLTE/frontend/notice/notice_dashboard',['application' => $application]);
    }


    public function create()
    {  
        return view('AdminLTE/frontend/notice/notice_create');
    }

    public function store(Request $request)
    {
         // Instantiate a new LeaveApplication model
        $leaveApplication = new notice();

          // Assign values to the properties
         $leaveApplication->application_type = $request->input('application_type');
         $leaveApplication->application_message = $request->input('application_message');
         $leaveApplication->application_start_date = $request->input('application_start_date');
         $leaveApplication->application_end_date = $request->input('application_end_date');
         $leaveApplication->approved_user_id = 0;
         // Save the leave application to the database
         $leaveApplication->save();

         return redirect()->route('notice_home')->with('success', 'Leave application submitted successfully!');
    }


    public function edit(Request $request, $id)
    {
        $leave= notice::find($id);
        return view('AdminLTE/frontend/notice/notice_edit',['leave' => $leave]);
    }


    public function update(Request $request)
    {
         $id=$request->input('leave_id') ;
         $leave = notice::find($id);
         $leave->application_type = $request->input('application_type');
         $leave->application_message = $request->input('application_message');
         $leave->application_start_date = $request->input('application_start_date');
         $leave->application_end_date = $request->input('application_end_date');
         $leave->approved_user_id = 0;
         $leave->update();
         return redirect()->route('notice_home')->with('success', 'Leave application updated successfully!');
        
    }


    public function destroy($id)
    {
        $item = notice::find($id);
        
        if (!$item) {
            return redirect()->route('notice_home')->with('error', 'Item not found!');
        }

        $item->delete();
        return redirect()->route('notice_home')->with('success', 'Item deleted successfully!');

    }

}
