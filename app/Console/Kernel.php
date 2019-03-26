<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('backup:clean')->daily()->at('01:00');
        //$schedule->command('backup:run')->daily()->at('02:00');
        // $schedule->command('inspire')->everyTenMinutes();
        //$schedule->command('test')->everyMinute();
        $schedule->command('bid')->daily()->at('02:00');
        $schedule->command('ten-bid')->daily()->at('02:00');
        $schedule->command('auto-bid')->daily()->at('02:00');
        $schedule->command('checkout-bid')->daily()->at('02:00');
        $schedule->command('del-robot')->daily()->at('02:00');
        $schedule->command('clear-visit')->daily()->at('02:00');
        $schedule->command('del-bid')->daily()->at('02:00');
        //  $schedule->command('create-robot-period')->daily()->at('02:00');
        //$schedule->command('route:list')->dailyAt('02:00');
        // $schedule->command('inspire')
        //          ->hourly();
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
