<?php 
// app/Http/Controllers/Auth/CustomLoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    // Show the login form
    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
    $inputValue = $request->input('email');
    
    if (filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
        // If the input is a valid email address
        $credentials = [
            'email' => $inputValue,
            'password' => $request->input('password'),
        ];
    } else {
        // If the input is not a valid email address, assume it's a phone number
        $credentials = [
            'phone_number' => $inputValue,
            'password' => $request->input('password'),
        ];
    }

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        return redirect()->route('admin_dashboard');
    }

    return redirect()->back()->withErrors([
        'email' => 'Invalid email address or phone number',
    ]);
}
    // Logout the user
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
