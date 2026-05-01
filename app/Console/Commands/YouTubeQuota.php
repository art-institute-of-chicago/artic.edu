<?php

namespace App\Console\Commands;

use App\Services\OAuth\GoogleOAuthService;
use App\Services\YouTube\YouTubeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\OutputInterface;

class YouTubeQuota extends Command
{
    protected $signature = 'youtube:quota';
    protected $description = 'Display the daily quota usage information';

    protected YouTubeService $youtube;

    public function __construct(GoogleOAuthService $oAuth)
    {
        parent::__construct();
        $oAuth->setApplicationName(YouTubeService::SERVICE_NAME);
        $this->youtube = new YouTubeService($oAuth->client);
        $this->youtube->setLogger($this->log(...));
    }

    public function handle()
    {
        $remaining = $this->youtube->getRemainingQuota();
        $resetsAt = $this->youtube->getResetsAt(config('app.timezone'));
        $resetsInHours = floor(now()->diffInHours($resetsAt));
        $resetsInMinutes = floor(now()->diffInRealMinutes($resetsAt)) % 60;
        $hours = $resetsInHours ? "$resetsInHours hours" : '';
        $minutes = $resetsInMinutes ? "$resetsInMinutes minutes" : '';
        $resets = $resetsAt->format('M j, g:iA');
        $this->info(
            "YouTube service quota - remaining: $remaining, resets in: $hours $minutes ($resets)",
            OutputInterface::VERBOSITY_QUIET,
        );
    }

    protected function log($message, $level = 'info')
    {
        Log::channel('sentry_logs')->{$level}($message);
        $this->{$level}($message, OutputInterface::VERBOSITY_DEBUG);
    }
}
