<?php

namespace App\Http\Controllers\Notifications;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class NotificationController extends Controller
{
    public function markAsRead(Notification $notification)
    {
        $notification->update(['read' => true]);
        return redirect()->back();
    }
}
