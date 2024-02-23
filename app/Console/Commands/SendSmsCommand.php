<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Xenon\LaravelBDSms\Provider\BulkSmsBD;
use Xenon\LaravelBDSms\Sender;

# call the model
use App\Models\reg_user;
use Carbon\Carbon;

class SendSmsCommand extends Command implements ShouldQueue
{
    protected $signature = 'send:sms';
    protected $description = 'Send an SMS using Xenon\LaravelBDSms';

    
    public function handle()
    {
        // Get today's date
        $today = Carbon::now();
    
        // Get users whose birthday is today and haven't received SMS yet
        $users = reg_user::whereDay('DOB', $today->day)
            ->whereMonth('DOB', $today->month)
            ->where('birthday_sms_sent', false)
            ->get();
    
        // Check if there are users with birthdays today
        if ($users->isNotEmpty()) {
            // Set up SMS sender
            $sender = Sender::getInstance();
            $sender->setProvider(BulkSmsBD::class);
            $sender->setQueue(true);
            $sender->setConfig([
                'api_key' => 'qfI5bCOCc04w4812MUv4',
                'type' => 'text',
                'senderid' => '8809617615488',
            ]);
    
            // Loop through users and send birthday SMS
            foreach ($users as $user) {
                $sender->setMobile($user->phone_number);
                $sender->setMessage('Happy Birthday, ' . $user->name . '! 🎉🎂');
                $status = $sender->send();
    
                // Mark that SMS has been sent
                $user->update(['birthday_sms_sent' => true]);
    
                $this->info('Birthday SMS sent to ' . $user->name);
            }
        } else {
            $this->info('No users have birthdays today or they have already received SMS.');
        }
    }
    
}
