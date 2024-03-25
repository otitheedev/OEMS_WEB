<?php

use Illuminate\Support\Facades\Route;
use App\Models\Permission; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;



Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('optimize');
    return 'Caches cleared and configuration files regenerated.';
});



#### php artisan serve --host 192.168.68.231 --port 8080
#### php artisan migrate:refresh --path=/database/migrations/2024_10_12_000000_create_p_medical_history.php

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


#################### Leave Application ####################
Route::get('/admin/application', [App\Http\Controllers\LeaveApplicationController::class, 'index'])->name('application_home');
Route::get('/admin/application/create', [App\Http\Controllers\LeaveApplicationController::class, 'create'])->name('application_create');
Route::post('/admin/application/store', [App\Http\Controllers\LeaveApplicationController::class, 'store'])->name('application_store');
Route::get('/admin/application/edit/{id}', [App\Http\Controllers\LeaveApplicationController::class, 'edit'])->name('application_edit1');
Route::post('/admin/application/update', [App\Http\Controllers\LeaveApplicationController::class, 'update'])->name('application_update1');
Route::get('/admin/application/destroy/{id}', [App\Http\Controllers\LeaveApplicationController::class, 'destroy'])->name('application_destroy');


########## Login ###########
Route::post('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'login'])->name('login');
Route::get('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'login'])->name('loginweb');
Route::post('/logout', [App\Http\Controllers\Auth\CustomLoginController::class, 'logout'])->name('logout');

# AjaxDataTable
Route::get('/AjaxDataTable', [App\Http\Controllers\FrontendController::class, 'AjaxDataTable'])->name('AjaxDataTable');


######### OEMS START ###################
//AuthController.php getAjaxDataTable All_Users_Index
Route::get('/employee/ID/{phone}', [App\Http\Controllers\FrontendController::class, 'profile'])->name('employee_profilex');
Route::get('/search/employee', [App\Http\Controllers\FrontendController::class, 'employee'])->name('employee_information');

# Admin Dashboard
Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'admin_dashboard'])->name('admin_dashboard')->middleware('auth'); ;

## redirect users to login Page
Route::get('/', function () {$message = Session::get('authRedirectMessage');return view('index', compact('message'));})->name('root_index');

######################## middleware start ########################
Route::group(['middleware' => ['auth', 'role:admin,HR,GM']], function () {


## AddRole Admins
Route::get('/admin/addRole/', [App\Http\Controllers\Admin\AdminController::class, 'home'])->name('addRole_admin_home');
Route::get('/admin/addRole/addRole/{id}', [App\Http\Controllers\Admin\AdminController::class, 'addRole'])->name('edit');
Route::get('/admin/allRoles/', [App\Http\Controllers\Admin\AdminController::class, 'allRoles'])->name('allRoles_admin');
Route::post('/admin/addRole/addRole/update', [App\Http\Controllers\Admin\AdminController::class, 'addRoleUpdate'])->name('rolename_update');
Route::get('/admin/addRole/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('edits');
Route::post('/admin/addRole/update', [App\Http\Controllers\Admin\AdminController::class, 'update'])->name('update');
Route::get('/admin/addRole/destroy/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('addRole_admin_destroy');


#################### Notice Board ####################
Route::get('/admin/notice', [App\Http\Controllers\NoticeController::class, 'index'])->name('notice_home');
Route::get('/admin/noticeAjax', [App\Http\Controllers\NoticeController::class, 'noticeAjax'])->name('notice_homenoticeAjax');


Route::get('/admin/notice/create', [App\Http\Controllers\NoticeController::class, 'create'])->name('notice_create');
Route::post('/admin/notice/store', [App\Http\Controllers\NoticeController::class, 'store'])->name('notice_store');
Route::get('/admin/notice/edit/{id}', [App\Http\Controllers\NoticeController::class, 'edit'])->name('notice_edit1');
Route::post('/admin/notice/update', [App\Http\Controllers\NoticeController::class, 'update'])->name('notice_update1');
Route::get('/admin/notice/destroy/{id}', [App\Http\Controllers\NoticeController::class, 'destroy'])->name('notice_destroy');


#################### Holiday Event ####################
Route::get('/admin/holiday', [App\Http\Controllers\HolidayController::class, 'index'])->name('holiday_home');

Route::get('/admin/holidayAjax', [App\Http\Controllers\HolidayController::class, 'indexAjax'])->name('holiday_homeindexAjax');

Route::get('/admin/holiday/create', [App\Http\Controllers\HolidayController::class, 'create'])->name('holiday_create');
Route::post('/admin/holiday/store', [App\Http\Controllers\HolidayController::class, 'store'])->name('holiday_store');
Route::get('/admin/holiday/edit/{id}', [App\Http\Controllers\HolidayController::class, 'edit'])->name('holiday_edit1');
Route::post('/admin/holiday/update', [App\Http\Controllers\HolidayController::class, 'update'])->name('holiday_update1');
Route::get('/admin/holiday/destroy/{id}', [App\Http\Controllers\HolidayController::class, 'destroy'])->name('holiday_destroy');




#Activity log:
Route::get('/admin/activitylogs', [App\Http\Controllers\FrontendController::class, 'activitylogs'])->name('activitylogs');
Route::get('/admin/activitylogsAJAX', [App\Http\Controllers\FrontendController::class, 'activitylogsAJAX'])->name('activitylogsAJAX');


## SMS RELATED TEST ###
Route::get('/admin/sms/createSMS', [App\Http\Controllers\Admin\AdminController::class, 'createSMS'])->name('createSMS');
Route::get('/admin/sms/', [App\Http\Controllers\Admin\AdminController::class, 'SMS'])->name('SMS');

#Route::get('/admin', function () { return view('AdminLTE/index'); });

# departments
Route::get('/admin/department', [App\Http\Controllers\DepartmentController::class, 'index'])->name('department_home');
Route::get('/admin/department/create', [App\Http\Controllers\DepartmentController::class, 'create'])->name('create');
Route::post('/admin/department/store', [App\Http\Controllers\DepartmentController::class, 'store'])->name('store');
Route::get('/admin/department/edit/{id}', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('edit1');
Route::post('/admin/department/update', [App\Http\Controllers\DepartmentController::class, 'update'])->name('update1');
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

# Read Notifications #
Route::get('/mark-as-read/{notification}', [App\Http\Controllers\Notifications\NotificationController::class, 'markAsRead'])->name('mark-as-read');

######### OEMS End ###################



### Dustbin ###
#............. DD TEST CODE .............#
Route::get('/admin/hitGET', function () {if (request()->isMethod('get')) {dd(request()->all());}});
#Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
