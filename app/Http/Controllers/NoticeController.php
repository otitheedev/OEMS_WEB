<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\notice;
use App\Models\reg_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Xenon\LaravelBDSms\Provider\BulkSmsBD;
use Xenon\LaravelBDSms\Sender;

class NoticeController extends Controller{

    public function index() {  
        return view('AdminLTE/frontend/notice/notice_dashboard');
    }

    public function noticeAjax() {  
        $model = notice::query()->orderBy('created_at', 'desc');
		
        return DataTables::eloquent($model)
            ->addColumn('custom_id', function($row) {
                return $row->id;
            })
            ->addColumn('custom_notice_type', function($row) {
                return $row->notice_type;
            })
            ->addColumn('custom_notice_message', function($row) {
                return $row->notice_message;
            })
            ->addColumn('custom_created_at', function($row) {
                return $row->created_at->format('d M, Y');
            })
            ->addColumn('action', function($row) {
                $actions = '';
                if (auth()->check() && auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root'])) {
                    $actions .= '<a href="/admin/notice/destroy/' . $row->id . '" class="btn-sm btn-danger">Delete</a> ';
                    $actions .= '<a href="/admin/notice/edit/' . $row->id . '" class="btn-sm btn-info">Edit</a>';
                }
                return $actions;
            })
            ->rawColumns(['custom_notice_message', 'action']) // Render HTML for these columns
            ->toJson();
    }

    public function notice_view(Request $request, $id) {
        $all_notice= notice::latest()->paginate(20);
        $notice_count= notice::count();
        $notice_view= notice::find($id);
        return view('AdminLTE/frontend/notice/notice_view',[
            'notice_view' => $notice_view,
            'all_notice' => $all_notice,
            'notice_count' => $notice_count,
        ]);
    }

    public function create() {  
        return view('AdminLTE/frontend/notice/notice_create');
    }

    public function store(Request $request) {
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


   ####################################################
   if($request->input('notice_type') == 'Important'){
    $noticeMessage = strip_tags($request->input('notice_message'));
    $users = reg_user::get();
    if ($users->isNotEmpty()) {
        // Set up SMS sender
        $sender = Sender::getInstance();
        $sender->setProvider(BulkSmsBD::class);
        $sender->setQueue(true);
        $sender->setConfig([
            'api_key' => 'qfI5bCOCc04w4812MUv4',
            'type' => 'text',
            'senderid' => '8809617615488',
        ]);

        // Loop through users and send birthday SMS
        foreach ($users as $user) {
            $sender->setMobile($user->phone_number);
            $sender->setMessage($noticeMessage);
            $status = $sender->send();
            // Mark that SMS has been sent
            #$user->update(['birthday_sms_sent' => true]);
            #$this->info('Birthday SMS sent to ' . $user->name);
        }
     }
    }
    ####################################################

         $notice_store->save();
         return redirect()->route('notice_home')->with('success', 'Notice Created successfully!');
    }

    public function edit(Request $request, $id){
        $notice= notice::find($id);
        return view('AdminLTE/frontend/notice/notice_edit',['notice' => $notice]);
    }


    public function update(Request $request){
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
         return redirect()->route('notice_home')->with('success', 'Notice updated successfully!');
        
    }

    public function destroy($id){
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
