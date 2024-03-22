<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
#ajaxDataTable
Route::get('/AjaxDataTable', [App\Http\Controllers\Api\AuthController::class, 'getAjaxDataTable'])->name('employee_profile');
});

//AUTH
use App\Http\Controllers\Api\AuthController;

## Auth
Route::post('/register', [AuthController::class, 'create_users']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', [AuthController::class, 'dashobard']);

# Employee
Route::get('/employees', [AuthController::class, 'get_employees']);
Route::get('/employees/{number}', [AuthController::class, 'get_employees_profile']);
Route::get('/employees_search', [AuthController::class, 'search_get_employees']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
