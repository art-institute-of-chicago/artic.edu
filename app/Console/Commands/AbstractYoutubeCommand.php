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

    protected GoogleOAuthService $oAuth;
    protected YouTubeService $youtube;

    public function __construct(GoogleOAuthService $oAuth)
    {
        $this->oAuth = $oAuth;
        $this->signature = Str::replace('{signature}', $this->signature, $this->signatureTemplate);
        parent::__construct();
        $this->oAuth->setApplicationName(YouTubeService::SERVICE_NAME . ' (gzip)');
        $this->youtube = new YouTubeService($oAuth->client);
        $this->youtube->setLogger(fn ($message, $level = 'info') => (
            $this->{$level}($message, OutputInterface::VERBOSITY_DEBUG)
        ));
    }

    public function handle()
    {
        $this->oAuth->authorizeWithAccessToken();
        $this->info(
            "YouTube service session start",
            OutputInterface::VERBOSITY_DEBUG,
        );
        // If the options are null, let them be, otherwise cast their types.
        $quota = is_null($this->option('quota')) ? $this->option('quota') : (int) $this->option('quota');
        $force = is_null($this->option('force')) ? $this->option('force') : (bool) $this->option('force');
        try {
            $this->youtube->clearSession()->session(fn () => $this->handleCommand(), $quota, $force);
        } catch (YouTubeServiceException $exception) {
            $code = $exception->getCode();
            $this->error($exception->getMessage(), OutputInterface::VERBOSITY_QUIET);
        }
        $requestCount = $this->youtube->getRequestCount();
        $sessionUsage = $this->youtube->getSessionUsage();
        $remainingQuota = $this->youtube->getRemainingQuota(quiet: true);
        $level = 'info';
        // Less than 10% of the daily limit
        if ($remainingQuota <= 0) {
            $level = 'error';
        } elseif ($remainingQuota < YouTubeService::QUOTA_LIMIT * .10) {
            $level = 'warn';
        }
        $this->{$level}(
            'YouTube service session end - ' .
                "request count: $requestCount, " .
                "quota usage: $sessionUsage, " .
                "remaining quota: $remainingQuota",
            OutputInterface::VERBOSITY_DEBUG
        );

        return $code ?? 0;
    }

    abstract protected function handleCommand();
}
