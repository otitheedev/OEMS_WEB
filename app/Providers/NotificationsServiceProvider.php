<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Route; // Add this line

class NotificationsServiceProvider extends ServiceProvider
{
    public function boot()
    {
  // View composer remains the same
  View::composer('*', function ($view) {
    if (Auth::check()) {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $all_notifications = Notification::where('user_id', Auth::id())
            ->where('read', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // You can add additional conditions if needed
        $view->with('notifications', $notifications)
     ->with('all_notifications', $all_notifications);
    }
});

    
}
    

    public function register()
    {
        //
    }
}