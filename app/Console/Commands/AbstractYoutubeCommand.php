<?php

namespace App\Console\Commands;

use App\Services\OAuth\GoogleOAuthService;
use App\Services\YouTube\YouTubeService;
use App\Services\YouTube\YouTubeServiceException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractYoutubeCommand extends Command
{
    protected $signatureTemplate = '{signature}
        {--F|force : Ignore quotas, only stop on 400s from the API}
        {--Q|quota= : The amount of quota points to use for the session}';

    protected YouTubeService $youtube;

    public function __construct(GoogleOAuthService $oAuth)
    {
        $this->signature = Str::replace('{signature}', $this->signature, $this->signatureTemplate);
        parent::__construct();
        $oAuth->setApplicationName('Art Institute of Chicago Video Import (gzip)');
        $this->youtube = new YouTubeService($oAuth->client);
        $this->youtube->setLogger(fn ($message) => $this->info($message, OutputInterface::VERBOSITY_DEBUG));
    }

    public function handle()
    {
        $this->info(
            "YouTube service session start",
            OutputInterface::VERBOSITY_DEBUG,
        );
        try {
            $this->youtube->session(fn () => $this->handleCommand(), $this->option('quota'), $this->option('force'));
        } catch (YouTubeServiceException $exception) {
            $code = $exception->getCode();
            $this->error($exception->getMessage(), OutputInterface::VERBOSITY_QUIET);
        }
        $this->info(
            'YouTube service session end - ' .
                "request count: {$this->youtube->getRequestCount()}, " .
                "quota usage: {$this->youtube->getSessionUsage()}",
            OutputInterface::VERBOSITY_DEBUG
        );

        return $code ?? 0;
    }

    abstract protected function handleCommand();
}
