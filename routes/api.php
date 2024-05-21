<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {

#ajaxDataTable
Route::get('/get-users-ajax-datatable', [AuthController::class, 'getAjaxUserData'])->name('employee_profile_datatable');

#Dashboard
Route::get('/dashboard', [AuthController::class, 'dashobard']);
Route::get('/notice', [AuthController::class, 'all_notice']);
Route::get('/department', [AuthController::class, 'all_department']);
Route::get('/leave_application', [AuthController::class, 'leave_applications']);

#Submit Leave Application
Route::middleware(['auth:sanctum'])->post('/submit_leave_applications', [AuthController::class, 'submit_leave_applications']);

# Employee
Route::get('/employees', [AuthController::class, 'get_employees']);
Route::get('/employees/{number}', [AuthController::class, 'get_employees_profile']);
Route::get('/employees_search', [AuthController::class, 'search_get_employees']);

});

## Auth
Route::post('/register', [AuthController::class, 'create_users']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
