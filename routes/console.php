<?php

use App\Helpers\QuoteHelpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(QuoteHelpers::quote());
})->purpose('Display an inspiring quote');

Schedule::command('cache:prune-stale-tags')->hourly()->sentryMonitor();
Schedule::command('sitemap:generate')->twiceDaily()->sentryMonitor();
Schedule::command('update:links')->daily()->sentryMonitor();
Schedule::command('update:cdn-ips')->hourly()->sentryMonitor();
Schedule::command('fix:galleries')->everyMinute()->sentryMonitor();
Schedule::command('send:confirmations')->everyTwoMinutes()->withoutOverlapping()->sentryMonitor();
Schedule::command('exhibitions:featured')->dailyAt('00:00')->sentryMonitor();

// Let production have the whole API quota
if (App::environment('production')) {
    Schedule::command('youtube:videos-and-playlists')->hourlyAt(17)->withoutOverlapping()->sentryMonitor();
    Schedule::command('youtube:captions')->hourlyAt(47)->withoutOverlapping()->sentryMonitor();
}
