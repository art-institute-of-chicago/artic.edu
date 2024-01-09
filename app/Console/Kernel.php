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
        Commands\InvalidateCloudfront::class,
        Commands\GenerateSitemap::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('cache:prune-stale-tags')->hourly();
        $schedule->command('sitemap:generate')->twiceDaily();
        $schedule->command('update:links')->daily();
        $schedule->command('update:cloudfront-ips')->hourly();
        $schedule->command('fix:galleries')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        $this->load(__DIR__ . '/Commands/Events');

        require base_path('routes/console.php');
    }
}
