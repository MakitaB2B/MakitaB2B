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
        // $schedule->command('inspire')->hourly();

        // $schedule->command("daily:promo-follow-up")    //->cron("*/15 2-23 * * *")->onOneServer();
        // $schedule->command("queue:pending-payments --all")->daily()->onOneServer();

        // $schedule->command("stp:monitoring --tenant=".$tenant->id)->dailyAt('11:00');
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
