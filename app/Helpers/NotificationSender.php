<?php

namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationSender
{

    public static function NotificationSend($message, Request $request){
        $user = auth()->user();
        $userID = $user->id;

        $logData = [
            'user_id' => $userID,
            'message' => $message,
            'read' => false,
        ];
      Notification::create($logData);
    }

    public static function NotificationLists(){
        return Notification::latest()->get();
    }

    
}
