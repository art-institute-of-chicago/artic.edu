<?php

namespace App\Console\Commands;

use App\Services\OAuth\GoogleOAuthService;
use App\Services\YouTube\YouTubeService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;

class YouTubeQuota extends Command
{
    protected $signature = 'youtube:quota {--R|resets : Include }';
    protected $description = 'Display the daily quota usage information';

    protected YouTubeService $youtube;

    public function __construct(GoogleOAuthService $oAuth)
    {
        parent::__construct();
        $oAuth->setApplicationName('Art Institute of Chicago Video Import (gzip)');
        $this->youtube = new YouTubeService($oAuth->client);
        $this->youtube->setLogger(fn ($message) => $this->info($message, OutputInterface::VERBOSITY_DEBUG));
    }

    public function handle()
    {
        $remaining = $this->youtube->getRemainingQuota();
        $resetsAt = $this->youtube->getResetsAt();
        $resetsInHours = floor(now()->diffInHours($resetsAt));
        $resetsInMins = floor(now()->diffInRealMinutes($resetsAt)) % 60;
        $this->info(
            "YouTube service quota - remaining: $remaining, resets in: $resetsInHours hours $resetsInMins minutes",
            OutputInterface::VERBOSITY_QUIET,
        );
    }
}
