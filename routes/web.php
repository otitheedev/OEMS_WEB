<?php

use Illuminate\Support\Facades\Route;
use App\Models\Permission; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;


#### php artisan serve --host 192.168.68.231 --port 8080
#### php artisan migrate:refresh --path=/database/migrations/subcategory_newtable_for_description_and_keywords.php

/* 
php artisan db:seed
php artisan send:sms
.............................
php artisan schedule:run
php artisan schedule:run >> /dev/null 2>&1 
..............................
*/

### BirthDAY SMS COMMAND
Route::get('/birthdaySMSCommand', function () {
    Artisan::call('send:sms');
    $output = Artisan::output();
    return "send:sms command executed. Output: $output";
});


### queue COMMAND
Route::get('/runqueueworker', function () {
    Artisan::call('queue:work', ['--timeout' => 9000]);
    $output = Artisan::output();
    return "queue:work command executed. Output: $output";
});


# AjaxDataTable
Route::get('/AjaxDataTable', [App\Http\Controllers\FrontendController::class, 'AjaxDataTable'])->name('employee_profile');

######### OEMS START ###################
//AuthController.php getAjaxDataTable All_Users_Index
Route::get('/employee/ID/{phone}', [App\Http\Controllers\FrontendController::class, 'profile'])->name('employee_profile');
Route::get('/search/employee', [App\Http\Controllers\FrontendController::class, 'employee'])->name('employee_information');

## redirect users to login Page
Route::get('/', function () {$message = Session::get('authRedirectMessage');return view('index', compact('message'));})->name('root_index');

######################## middleware start ########################
Route::group(['middleware' => ['auth', 'role:admin,HR,GM']], function () {

## SMS RELATED TEST ###
Route::get('/admin/sms/createSMS', [App\Http\Controllers\Admin\AdminController::class, 'createSMS'])->name('createSMS');
Route::get('/admin/sms/', [App\Http\Controllers\Admin\AdminController::class, 'SMS'])->name('SMS');

#Route::get('/admin', function () { return view('AdminLTE/index'); });
Route::get('/admin', [App\Http\Controllers\UserController::class, 'admin_dashboard'])->name('admin_dashboard');

## AddRole Admins
Route::get('/admin/addRole/', [App\Http\Controllers\Admin\AdminController::class, 'home'])->name('addRole_admin_home');
Route::get('/admin/addRole/addRole/{id}', [App\Http\Controllers\Admin\AdminController::class, 'addRole'])->name('edit');
Route::get('/admin/allRoles/', [App\Http\Controllers\Admin\AdminController::class, 'allRoles'])->name('allRoles_admin');
Route::post('/admin/addRole/addRole/update', [App\Http\Controllers\Admin\AdminController::class, 'addRoleUpdate'])->name('rolename_update');
Route::get('/admin/addRole/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('edit');
Route::post('/admin/addRole/update', [App\Http\Controllers\Admin\AdminController::class, 'update'])->name('update');
Route::get('/admin/addRole/destroy/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('addRole_admin_destroy');

# departments
Route::get('/admin/department', [App\Http\Controllers\DepartmentController::class, 'index'])->name('department_home');
Route::get('/admin/department/create', [App\Http\Controllers\DepartmentController::class, 'create'])->name('create');
Route::post('/admin/department/store', [App\Http\Controllers\DepartmentController::class, 'store'])->name('store');
Route::get('/admin/department/edit/{id}', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('edit');
Route::post('/admin/department/update', [App\Http\Controllers\DepartmentController::class, 'update'])->name('update');
Route::get('/admin/department/destroy/{id}', [App\Http\Controllers\DepartmentController::class, 'destroy'])->name('destroy');

# Users
Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'all_users_index'])->name('users_home');
Route::get('/admin/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users_create');
Route::post('/admin/users/store', [App\Http\Controllers\UserController::class, 'create_users']);
Route::post('/admin/users/update/{id}', [App\Http\Controllers\UserController::class, 'update_users']); ########
Route::get('/admin/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users_edit');
Route::get('/admin/users/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users_destroy');

});

######################## middleware end ########################



// MiddleWare for Admin And Other Users Checking
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/1', function () {return "admin Role";});
});

Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/2', function () {return "user Role";});
});

// MiddleWare for Users Permission Checking
Route::group(['middleware' => ['auth', 'permission:create_post']], function () {
    // Routes accessible only by users with the 'create_post' permission
    Route::get('/3', function () {return "permission:create_post";});
});

Route::group(['middleware' => ['auth', 'permission:edit_post']], function () {
    Route::get('/4', function () {return "permission:edit_post";});
});

Route::group(['middleware' => ['auth', 'permission:delete_post']], function () {
    // Routes accessible only by users with the 'delete_post' permission
});

######### OEMS End ###################



### Dustbin ###
#............. DD TEST CODE .............#
Route::get('/admin/hitGET', function () {if (request()->isMethod('get')) {dd(request()->all());}});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');