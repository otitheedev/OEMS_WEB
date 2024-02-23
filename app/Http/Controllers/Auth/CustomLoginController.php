<?php 
// app/Http/Controllers/Auth/CustomLoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Your custom login logic here
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
