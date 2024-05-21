<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class apiAuthKey
{
    public function handle($request, Closure $next)
    {

        // Check if the current route should be excluded from the middleware
         if ($request->is('api/get-users-ajax-datatable')) {
            return $next($request);
        }


        $username = $request->header('X-Username');
        $key = $request->header('X-Key');

        // Check if username and key are valid (you should replace this with your own logic)
        if ($this->isValidCredentials($username, $key)) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    private function isValidCredentials($username, $key)
    {
        #$envUsername = env('JSONAPI_USERNAME', 'default_username');
        #$envKey = env('JSONAPI_KEY', 'default_key');
        
        $envUsername = "OT@ossl655";
        $envKey = "oks03o3++f2DP5bJOIL3U8pqjNGbTmX";

        return ($username === $envUsername && $key === $envKey);
    }
}
