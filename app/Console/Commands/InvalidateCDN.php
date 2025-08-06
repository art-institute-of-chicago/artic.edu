<?php

namespace App\Console\Commands;

use A17\Twill\Services\Cache\CloudfrontCacheService;
use App\Services\Cache\CloudflareCacheService;
use Illuminate\Console\Command;

class InvalidateCDN extends Command
{
    protected $signature = 'cache:invalidate-cdn {urls?*}';

    protected $description = 'Invalidate CDN distribution.';

    public function handle()
    {
        if (config('services.cloudflare.enabled')) {
            if (!empty($this->argument('urls'))) {
                app(CloudflareCacheService::class)->purge($this->argument('urls'));
            }

            $this->info('Cloudflare invalidation request sent!');
        }
        if (config('services.cloudfront.enabled')) {
            if (!empty($this->argument('urls'))) {
                app(CloudfrontCacheService::class)->invalidate($this->argument('urls'));
            }

            $this->info('Cloudfront invalidation request sent!');
        }
    }
}
