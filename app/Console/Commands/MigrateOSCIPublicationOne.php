<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Api\PublicationRepository;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationSection;
use App\Models\Vendor\Block;

class MigrateOSCIPublicationOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:osci-publication {id : Publication ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate an OSCI publication to a website DigitalPublication';

    protected $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PublicationRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pubId = $this->argument('id');

        $apiPub = $this->repository->getById($pubId);
        $webPub = new DigitalPublication();
        $webPub->title = 'Migrated ' . date('M j, Y') . ' | ' . $apiPub->title;
        $webPub->published = false;
        $webPub->is_dsc_stub = false;
        $webPub->save();

        foreach ($apiPub->sections as $apiSection) {
            $webSection = new DigitalPublicationSection();
            $webSection->title = $apiSection->title;
            $webSection->published = false;
            $webSection->digital_publication_id = $webPub->id;
            $webSection->position = $apiSection->weight;
            $webSection->save();

            $block = new Block();
            $block->blockable_id = $webSection->id;
            $block->blockable_type = 'App\Models\DigitalPublicationSection';

            /* If we decide to break up the text into multiple paragraph blocks, increment
             * the `position` value to keep the order in tact.
             */
            $block->position = 0;

            $block->content = ['paragraph' => str_replace(['<section', '</section'], ['<p', '</p'], $apiSection->content)];
            $block->type = 'paragraph';
            $block->save();
            $webSection->blocks()->save($block);

            $webPub->sections()->save($webSection);
        }
        $webPub->save();
    }
}
