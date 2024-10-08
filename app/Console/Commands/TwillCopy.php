<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class TwillCopy extends Command
{
    protected $signature = 'twill:copy';

    protected $description = 'Hard-copy our own customizations before twill:build';

    public function handle()
    {
        $sourcePath = resource_path('assets/js/twill-components/PublicationMediaField.vue');
        $destinationPath = base_path('vendor/area17/twill/frontend/js/components/PublicationMediaField.vue');
        File::copy($sourcePath, $destinationPath);

        $sourcePath = resource_path('assets/js/plugins/AicConfig.js');
        $destinationPath = base_path('vendor/area17/twill/frontend/js/plugins/AicConfig.js');
        File::copy($sourcePath, $destinationPath);
    }
}
