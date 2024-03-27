<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NoticeController extends Controller
{
    public function index()
    {  
        return view('AdminLTE/frontend/notice/notice_dashboard');
    }

    public function noticeAjax()
    {  
        $model = notice::query()->orderBy('created_at', 'desc');
        return DataTables::eloquent($model)->toJson();
    }

    public function notice_view(Request $request, $id){
        $all_notice= notice::latest()->paginate(20);
        $notice_count= notice::count();
        $notice_view= notice::find($id);
        return view('AdminLTE/frontend/notice/notice_view',[
            'notice_view' => $notice_view,
            'all_notice' => $all_notice,
            'notice_count' => $notice_count,
        ]);
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
        $notice= notice::find($id);
        return view('AdminLTE/frontend/notice/notice_edit',['notice' => $notice]);
    }


    public function update(Request $request)
    {
         $id=$request->input('notice_id') ;
         $notice_update = notice::find($id);
         $notice_update->notice_title = $request->input('notice_title');
         $notice_update->notice_type = $request->input('notice_type');
         $notice_update->notice_message = $request->input('notice_message');
         
         if ($request->hasFile('notice_file')) {
            $notice_file = $request->file('notice_file');
            if ($notice_update->notice_file) {
                $previous_file_path = public_path('assets/notice/' . $notice_update->notice_file);
                if (file_exists($previous_file_path)) {
                    unlink($previous_file_path);
                }
            }
            $extension = $notice_file->getClientOriginalExtension();
            $department_image_name = $request->input('notice_title') . '-file-.' . $extension;
            $notice_file->move('assets/notice/', $department_image_name);
            $notice_update->notice_file = $department_image_name;
        }
        
         $notice_update->update();
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
