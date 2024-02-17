<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the send:sms command to run once with a delay of 5 seconds
        $schedule->command('send:sms')->runInBackground()->after(function () {
            // Introduce a delay of 5 seconds using sleep
            sleep(5);

            // This closure runs after the command
            // Put any additional logic here if needed
        });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
