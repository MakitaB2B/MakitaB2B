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
         $currentYear = date('Y');
            $currentMonth = date('m');

            $firstDayOfMonth = new \DateTime("$currentYear-$currentMonth-01");

            $firstSaturday = clone $firstDayOfMonth;
            $firstSaturday->modify('first Saturday of this month');
            $firstsat=$firstSaturday->format('Y-m-d');

            $thirdSaturday = clone $firstSaturday;
            $thirdSaturday->modify('+2 weeks');
            $thirdsat=$thirdSaturday->format('Y-m-d');

            $today = now()->format('Y-m-d');

            if ($today !== $firstsat && $today !== $thirdsat) {
                $schedule->command('daily:promo-follow-up')->cron('0 6 * * 1-6');
                // $schedule->command("daily:promo-follow-up")->dailyAt('13:15');
            }
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
