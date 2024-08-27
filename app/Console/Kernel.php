<?php

namespace App\Console;

use App\Console\Commands\NotifyLaborContractExpired;
use App\Console\Commands\NotifyProbationContractExpired;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(NotifyLaborContractExpired::class)->dailyAt('08:10');
        $schedule->command(NotifyProbationContractExpired::class)->dailyAt('08:20');
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
