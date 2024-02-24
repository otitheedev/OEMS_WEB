<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;


class LogActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Log activity
        $user = Auth::user();

        $logData = [
            'user_id' => $user ? $user->id : null,
            'description' => 'Visited: ' . $request->fullUrl(),
            'ip_address' => $request->ip(),
            'url' => $request->fullUrl(),
            'browser_agent' => $request->header('User-Agent'),
        ];

        ActivityLog::create($logData);

        return $response;
    }
}
