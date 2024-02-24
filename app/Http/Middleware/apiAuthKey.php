<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class apiAuthKey
{
    public function handle($request, Closure $next)
    {
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
        // Replace this with your own logic to validate the username and key
        return ($username === 'needyamin@gmail.com' && $key === 'needyamin@gmail.com');
    }
}
