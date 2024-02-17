<?php

// Include necessary namespaces
namespace App\Http\Controllers;

use Illuminate\Http\Request; // For handling HTTP requests
use Illuminate\Support\Facades\Auth; // For handling authentication
use App\Models\User; // User model

// Define AuthController class which extends Controller
class AuthController extends Controller
{
// Function to handle user registration
public function register(Request $request)
{
// Validate incoming request fields
    $request->validate([
    'name' => 'required|string|max:255', 
    'email' => 'required|string|email|max:255|unique:users', 
    'password' => 'required|string|min:6', 
]);

// Create new User
$user = User::create([
'name' => $request->name,
'email' => $request->email,
'password' => bcrypt($request->password), 
]);

// Return user data as JSON with a 201 (created) HTTP status code
return response()->json(['user' => $user], 201);
}

// Function to handle user login
public function login(Request $request)
{
// Validate incoming request fields
$request->validate([
'email' => 'required|string|email', 
'password' => 'required|string', 
]);

// Check if the provided credentials are valid
if (!Auth::attempt($request->only('email', 'password'))) {
// If not, return error message with a 401 (Unauthorized) HTTP status code
return response()->json(['message' => 'Invalid login details'], 401);
}

// If credentials are valid, get the authenticated user
$user = $request->user();
// Create a new token for this user
$token = $user->createToken('authToken')->plainTextToken;

// Return user data and token as JSON
return response()->json(['user' => $user, 'token' => $token]);
}

// Function to handle user logout
public function logout(Request $request)
{
  // Delete all tokens for the authenticated user
  $request->user()->tokens()->delete();

   // Return success message as JSON
   return response()->json(['message' => 'Logged out']);
}
}