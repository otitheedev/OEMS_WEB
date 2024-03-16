<?php

namespace App\Http\Controllers;

use App\Models\notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        
         $notice_store = new notice();
         $notice_store->notice_title = $request->input('notice_title');
         $notice_store->notice_type = $request->input('notice_type');
         $notice_store->notice_message = $request->input('notice_message');
         //$notice_store->notice_file = $request->input('notice_file');
         
         if ($request->hasFile('notice_file')) {
            $notice_file = $request->file('notice_file');
            $extension = $notice_file->getClientOriginalExtension();
            $department_image_name = $request->input('notice_title') . '-file-.' . $extension;
            $notice_file->move('assets/notice/', $department_image_name);
            $notice_store->notice_file = $department_image_name;
        }
    

         $notice_store->save();
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

        $destination = public_path('assets/notice/') . $item->notice_file;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $item->delete();
        return redirect()->route('notice_home')->with('success', 'Item deleted successfully!');

    }

}
