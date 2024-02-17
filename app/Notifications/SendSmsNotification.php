<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Xenon\LaravelBDSms\Provider\BulkSmsBD;
use Xenon\LaravelBDSms\Sender;

class SendSmsNotification extends Notification
{
    public function toBDSms($notifiable)
    {
        $message = new Sender(new BulkSmsBD());
        $message->to($notifiable->routeNotificationFor('sms'))
            ->text($this->getMessage());

        return $message;
    }

    public function getMessage()
    {
        // Customize your SMS message content here
        return 'This is your SMS message.';
    }

    public function via($notifiable)
    {
        return ['bdsms'];
    }
}
