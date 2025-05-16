<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('cache:prune-stale-tags')->hourly();
Schedule::command('sitemap:generate')->twiceDaily();
Schedule::command('update:links')->daily();
Schedule::command('update:cloudfront-ips')->hourly();
Schedule::command('fix:galleries')->everyMinute();
Schedule::command('send:confirmations')->everyTwoMinutes()->withoutOverlapping();
Schedule::command('exhibitions:featured')->dailyAt('00:00');
