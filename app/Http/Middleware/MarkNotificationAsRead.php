<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class MarkNotificationAsRead
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

/*         // Mark notifications as read for the authenticated user
        if (Auth::check()) {
            Notification::where('user_id', Auth::id())->where('read', false)->update(['read' => true]);
        } */

        return $response;
    }
}