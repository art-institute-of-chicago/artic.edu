<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SentryTest extends Command
{
    protected $signature = 'app:sentry-test';
    protected $description = 'Sentry Test';

    public function handle()
    {
        Log::channel('stack')->info('Sentry test info log message');
        Log::channel('stack')->warning('Sentry test warning log message');
        Log::channel('stack')->error('Sentry test error log message', [
            'additional_info' => 'blah blah blah',
        ]);
        $this->info('Sentry test log messages sent');
    }
}
