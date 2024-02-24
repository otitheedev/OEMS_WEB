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


//ALL PRODUCTS
use app\Http\Controllers\API\regUsercontroller;
Route::apiResource('users', regUsercontroller::class);

//AUTH
use App\Http\Controllers\Api\AuthController;

## Auth
Route::post('/register', [AuthController::class, 'create_users']);
Route::post('/login', [AuthController::class, 'login']);

# Employee
Route::get('/employees/{number}', [AuthController::class, 'get_employees']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
