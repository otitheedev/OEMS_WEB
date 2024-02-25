<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\LogActivityHelper;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

   /*      // Log activity
        $user = Auth::user();

        $logSubject = 'Visited: ' . $request->fullUrl();

        LogActivityHelper::addToLog($logSubject, $request); */

        return $response;
    }
}
