<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, ...$permissions)
    {
        if (Auth::check() && Auth::user()->hasAnyPermission($permissions)) {
            return $next($request);
        }

        return abort(403, 'Unauthorized.'); // or redirect or custom response
    }
}
