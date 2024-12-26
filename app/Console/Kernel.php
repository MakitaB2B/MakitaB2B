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


            $currentYear = date('Y');
            $currentMonth = date('m');

            \Log::info("Current Year: $currentYear, Current Month: $currentMonth");


            $firstDayOfMonth = new \DateTime("$currentYear-$currentMonth-01");

            $firstSaturday = clone $firstDayOfMonth;
            $firstSaturday->modify('first Saturday of this month');
            $firstsat=$firstSaturday->format('Y-m-d');

            $thirdSaturday = clone $firstSaturday;
            $thirdSaturday->modify('+2 weeks');
            $thirdsat=$thirdSaturday->format('Y-m-d');

            \Log::info("First Saturday: $firstsat $thirdsat");

            $today = now()->format('Y-m-d');
            \Log::info($today);

            if ($today !== $firstsat && $today !== $thirdsat) {
                // $schedule->command('daily:promo-follow-up')->cron('0 6 * * 1-6');

                \Log::info("Scheduling daily:promo-follow-up command at 9:25");
                // $schedule->command("daily:promo-follow-up")->dailyAt('9:25');

                $schedule->command('daily:promo-follow-up')->cron('25 10 * * 1-6');

                \Log::info("Scheduling");

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
