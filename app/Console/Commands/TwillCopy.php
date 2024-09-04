<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TwillCopy extends Command
{
    protected $signature = 'twill:copy';

    protected $description = 'Hard-copy our own customizations before twill:build';

    public function handle()
    {
        $sourcePath = resource_path('assets/js/twill-components/media-library/MediaLibrary.vue');
        $destinationPath = base_path('vendor/area17/twill/frontend/js/components/media-library/MediaLibrary.vue');
        \File::copy($sourcePath, $destinationPath);
    }
}
