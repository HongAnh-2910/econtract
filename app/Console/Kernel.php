<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Mail\Contract\SendMailToClientSign;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\cronEmail'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $hourPrune = config('telescope.hour_prune');
        $schedule->command('demo:cronEmail')->timezone('Asia/Ho_Chi_Minh')->everyMinute()->runInBackground()->appendOutputTo(storage_path('logs/' . 'laravel_output.log'))->emailOutputOnFailure('duckhanhcao1@gmail.com');
        $schedule->command('telescope:prune --hours='.$hourPrune)->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
