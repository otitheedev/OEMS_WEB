<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogActivityHelper{

    public static function addToLog($subject, Request $request){
        $user = auth()->user();
        
        $logData = [
            'user_name' => $user ? $user->name : null,
            'description' => $subject,
            'ip_address' => $request->ip(),
            'url' => $request->fullUrl(),
            'browser_agent' => $request->header('User-Agent'),
        ];

        ActivityLog::create($logData);
    }

    public static function logActivityLists(){
        return ActivityLog::latest()->get();
    }
}
