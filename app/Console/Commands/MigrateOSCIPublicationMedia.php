<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateOSCIPublicationMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:osci-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all OSCI publications\' IIP and 360º media from OSCI servers to S3';

    protected $publications = [
        'albright',
        'americansilver',
        'caillebotte',
        'digitalwhistler',
        'ensor',
        'gauguin',
        'manet',
        'matisse',
        'modernseries',
        'modernseries2',
        'monet',
        'pissarro',
        'renoir',
        'romanart',
        'whistler_linkedvisions',
        'whistlerart',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->publications as $pub) {
            $this->call('migrate:osci-media-one', ['id' => $pub]);
        }
    }
}
