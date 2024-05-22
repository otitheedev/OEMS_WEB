<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DepartmentController extends Controller
{

    public function index() {
        $departments=department::all();
        return view('AdminLTE/frontend/Department/department',['department' => $departments]);
    }


    public function create() {
        return view('AdminLTE/frontend/Department/department_create');
    }


    public function store(Request $request) {
       ## Validate the request data
       $department = $request->validate([
        'department_name' => 'required|string',
        'department_photo' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
        'department_information' => 'required|string|min:25',
        'department_gm' => 'required|string',
        'department_director' => 'required|string',
    ]);

       $department = new department();
       $department->department_name = $request->input('department_name');
       $department->department_information = $request->input('department_information');
       $department->department_gm = $request->input('department_gm');
       $department->department_director = $request->input('department_director');

       ## Department image 1
       $image1 = $request->file('department_photo');
       if ($request->hasfile('department_photo')) {
           $extension = $image1->getClientOriginalExtension();
           $department_image_name = $department->department_name. '-photo-.' . $extension;
           $image1->move('assets/department/', $department_image_name);
           $department->department_photo = $department_image_name;
        }

       $department->save();
       return redirect()->route('department_home')->with('success', 'created successfully!');
    }



    public function edit(Request $request, $id) {
        $department= department::find($id);
        return view('AdminLTE/frontend/Department/department_edit',['department' => $department]);
    }


    public function update(Request $request) {
        ## Validate the request data
       $department = $request->validate([
        'department_name' => 'required|string',
        'department_photo' => 'mimes:jpeg,png,jpg,gif,svg|max:1000',
        'department_information' => 'required|string|min:5',
        'department_gm' => 'required|string',
        'department_director' => 'required|string',
    ]);

       $id=$request->input('department_id') ;
       $department = department::find($id);
       $department->department_name = $request->input('department_name');
       $department->department_information = $request->input('department_information');
       $department->department_gm = $request->input('department_gm');
       $department->department_director = $request->input('department_director');

       ## Department image 1
       $image1 = $request->file('department_photo');
       if ($request->hasfile('department_photo')) {
           $extension = $image1->getClientOriginalExtension();
           $department_image_name = $department->department_name. '-photo-.' . $extension;
           $image1->move('assets/department/', $department_image_name);
           $department->department_photo = $department_image_name;
        }

       $department->update();
       return redirect()->route('department_home')->with('success', 'created successfully!');
        
    }


    public function destroy($id) {
        $auth_number = Auth::user()->phone_number;
        $auth_email = Auth::user()->email;
        if($auth_number == '01878578504' && $auth_email == 'needyamin@gmail.com'){

        $item = department::find($id);
        
        if (!$item) {
            return redirect()->route('department_home')->with('error', 'Item not found!');
        }

        $destination = public_path('assets/department/') . $item->department_photo;
        if (File::exists($destination)) {
            File::delete($destination);
        }

        $item->delete();
        return redirect()->route('department_home')->with('success', 'Item deleted successfully!');
    }

else {
    return redirect()->route('users_home')->with('error', 'You can\'t delete this items. Please contact with superadmin');
}

    }
}
