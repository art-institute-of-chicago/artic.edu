<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class Release extends Command
{
    protected $signature = 'release {version : Version number to set}';

    protected $description = 'Bump the version number and run some small tasks';

    public function handle()
    {
        $this->info('Bumping version number...');
        $this->bumpVersionNumber();

        // Add any tasks that need to be run with releases here
    }

    private function bumpVersionNumber()
    {
        $version = $this->argument('version');

        Storage::disk('local')->put('VERSION', $version);

        $dest = base_path('VERSION');

        copy(storage_path('app/VERSION'), $dest);
    }
}
