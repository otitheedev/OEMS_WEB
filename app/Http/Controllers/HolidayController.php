<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\Models\holiday;
use Illuminate\Http\Request;
use DataTables;

class HolidayController extends Controller
{
    public function index(){  
        return view('AdminLTE/frontend/holiday/holiday_dashboard');
    }


    public function indexAjax(){  
    $model = holiday::query()->orderBy('created_at', 'desc');

    return DataTables::eloquent($model)
        ->addColumn('custom_id', function($row) {
            return $row->id;
        })
        ->addColumn('custom_holiday_type', function($row) {
            return $row->holiday_type;
        })
        ->addColumn('custom_holiday_message', function($row) {
            return $row->holiday_message;
        })
        ->addColumn('custom_start_date', function($row) {
            return $row->start_date->format('d M, Y');
        })
        ->addColumn('custom_end_date', function($row) {
            return $row->end_date->format('d M, Y');
        })
        ->addColumn('custom_created_at', function($row) {
            return $row->created_at->format('d M, Y');
        })
        ->addColumn('action', function($row) {
            $actions = '';
            if (auth()->check() && auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root'])) {
                $actions .= '<a href="/admin/holiday/destroy/' . $row->id . '" class="btn-sm btn-danger pl-2 pr-2">Delete</a>';
                $actions .= '<a href="/admin/holiday/edit/' . $row->id . '" class="btn-sm btn-info pl-2 pr-2">Edit</a>';
            }
            return $actions;
        })
        ->rawColumns(['custom_holiday_message', 'action']) // Render HTML for these columns
        ->toJson();

    }

    public function create(){  
        return view('AdminLTE/frontend/holiday/holiday_create');
    }

    public function store(Request $request){
         $holiday_store = new holiday();
         $holiday_store->holiday_title = $request->input('holiday_title');
         $holiday_store->holiday_type = $request->input('holiday_type');
         $holiday_store->holiday_message = $request->input('holiday_message');
         $holiday_store->start_date = $request->input('start_date');
         $holiday_store->end_date = $request->input('end_date');
         //$notice_store->notice_file = $request->input('notice_file');

         if ($request->hasFile('holiday_file')) {
            $holiday_file = $request->file('holiday_file');
            $extension = $holiday_file->getClientOriginalExtension();
            $department_image_name = $request->input('holiday_title') . '-file-.' . $extension;
            $holiday_file->move('assets/holiday_file/', $department_image_name);
            $holiday_store->holiday_file = $department_image_name;
        }
         $holiday_store->save();
         return redirect()->route('holiday_home')->with('success', 'Holiday Notice submitted successfully!');
    }


    public function edit(Request $request, $id){
        $holiday= holiday::find($id);
        return view('AdminLTE/frontend/holiday/holiday_edit',['holiday' => $holiday]);
    }


    public function update(Request $request){
         $id=$request->input('holiday_id') ;
         $holiday_update = holiday::find($id);
         $holiday_update->holiday_title = $request->input('holiday_title');
         $holiday_update->holiday_type = $request->input('holiday_type');
         $holiday_update->holiday_message = $request->input('holiday_message');
         $holiday_update->start_date = $request->input('start_date');
         $holiday_update->end_date = $request->input('end_date');
         //$notice_store->notice_file = $request->input('notice_file');

      // Your holiday file upload code starts here
      if ($request->hasFile('holiday_file')) {
            if ($request->hasFile('holiday_file')) {
             \File::delete(public_path('assets/holiday_file/' . $holiday_update->holiday_file));
         }
         $holiday_file = $request->file('holiday_file');
         $extension = $holiday_file->getClientOriginalExtension();
         $holiday_file_name = $holiday_update->start_date . '-file-.' . $extension;
         $holiday_file->move(public_path('assets/holiday_file/'), $holiday_file_name);
         $holiday_update->holiday_file = $holiday_file_name;
        }
         $holiday_update->update();
         return redirect()->route('holiday_home')->with('success', 'Holiday application updated successfully!');
        
    }


    public function destroy($id){
        $item = holiday::find($id);
        if (!$item){
            return redirect()->route('holiday_home')->with('error', 'Item not found!');
        }

        $destination = public_path('assets/holiday/') . $item->holiday_file;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $item->delete();
        return redirect()->route('holiday_home')->with('success', 'Item deleted successfully!');

    }


}
