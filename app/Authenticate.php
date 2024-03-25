<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Set a flash message before redirecting
        Session::flash('authRedirectMessage', 'Please log in to access this resource.');
        return $request->expectsJson() ? null : route('root_index');
    }
}
