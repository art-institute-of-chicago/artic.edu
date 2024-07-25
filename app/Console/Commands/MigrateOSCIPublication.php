<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateOSCIPublication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:osci-publication';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all OSCI publications from a migration file to website DigitalPublications';

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
            $this->call('migrate:osci-publication-one', ['id' => $pub]);
        }
    }
}
