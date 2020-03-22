<?php

namespace App\Console;

use App\Models\Moderation\Actions\Ban;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        /* $schedule->call(function () {
            Log::info('Looking for completed strikes...');
            $activeBans = Ban::cursor()->filter(function ($ban) {
                return $ban->current() && !$ban->permanent() && !$ban->overturn;
            })->sortByDesc('start_timestamp');
            Log::info('Found '. count($activeBans) .' active bans.');
        })->everyMinute(); */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
