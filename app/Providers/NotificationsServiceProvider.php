<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class NotificationsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->where('read', false)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $view->with('notifications', $notifications);
            }
        });
    }

    public function register()
    {
        //
    }
}