<?php

namespace App\Console\Commands;

use A17\CmsToolkit\Services\Cache\CloudfrontCacheService;
use Illuminate\Console\Command;

class InvalidateCloudfront extends Command
{

    protected $signature = 'cache:invalidate-cloudfront {urls?*}';

    protected $description = 'Invalidate cloudfront distribution.';

    public function handle()
    {
        if (config('cache.enable_cloudfront_cache')) {
            if (!empty($this->argument('urls'))) {
                app(CloudfrontCacheService::class)->invalidate($this->argument('urls'));
            } else {
                app(CloudfrontCacheService::class)->invalidate();
            }

            $this->info('Cloudfront invalidation request sent!');
        }
    }

}
