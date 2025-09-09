<?php

namespace App\Console\Commands;

use Google\Service\YouTube;
use Illuminate\Console\Command;

class ImportYouTube extends Command
{
    protected const HANDLE = '@artinstitutechi';

    protected string $signature = 'import:youtube';
    protected string $description = 'Import video data with YouTube';

    public function handle()
    {
        $client = new \Google\Client();
        $client->setApplicationName('Art Institute of Chicago Video Import');
        $client->setDeveloperKey(config('services.google_api.key'));
        $youtube = new YouTube($client);
        $response = $youtube->channels->listChannels('statistics', ['forHandle' => self::HANDLE]);
        dump('Video count: ' . $response['items'][0]['statistics']['videoCount']);
    }
}
