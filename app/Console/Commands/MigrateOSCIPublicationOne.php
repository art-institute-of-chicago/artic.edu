<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Repositories\Api\PublicationRepository;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;
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
    protected $description = 'Migrate an OSCI publication from a migration file to a website DigitalPublication';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pubId = $this->argument('id');

        // NB!: For each of these types in the admin UI it's impossible to validate the save without setting a date!

        $pubs = DB::connection('osci_migration')->select("SELECT json_extract(publications.data,'$._title') as title FROM publications LEFT JOIN tocs ON tocs.package=publications.pub_id WHERE pub_id=:id", ['id' => $pubId]);
        $pub = Arr::first($pubs);

        // TODO: Handle italics / etc in the title
        // TODO: Set any other publication level metadata (date?)

        $webPub = new DigitalPublication();
        $webPub->title = 'Migrated ' . date('M j, Y') . ' | ' . $pub->title;
        $webPub->published = false;
        $webPub->is_dsc_stub = false;
        $webPub->save();

        $webPubId = $webPub->id;

        $texts = DB::connection('osci_migration')->select("SELECT coalesce(json_extract(data,'$._title'),'FIXME') as title,text_id FROM texts WHERE package=:pubId and text_id NOT LIKE '%ncxtoc%'", ['pubId' => $pubId]);

        // Initialize the left value
        $lft = 1;

        foreach ($texts as $text) {
            $webArticle = new DigitalPublicationArticle();
            $webArticle->type = "text";
            $webArticle->title = $text->title;
            $webArticle->published = false;
            $webArticle->digital_publication_id = $webPubId;
            $webArticle->date = date('M j, Y');
            $webArticle->updated_at = date('M j, Y');
            $webArticle->created_at = date('M j, Y');
            $webArticle->_lft = $lft++;
            $webArticle->_rgt = $lft++;

            // TODO: Join toc position via json_tree against toc data
            $webArticle->position = 0;

            $webArticle->save();

            // TODO: Use a multiline string!! Also this can be moved outside the while

            $blocks = DB::connection('osci_migration')->select("SELECT json_extract(blk.value,'$.html') as html, blk.id as position, json_extract(blk.value,'$.blockType') as type, json_extract(blk.value,'$.fallback_url') as figure_url, coalesce(json_extract(blk.value,'$.caption_html'),'') as figure_capt from texts, json_each(texts.data,'$.sections') as sects,json_each(sects.value,'$.blocks') as blk where texts.text_id=:textId", ['textId' => $text->text_id]);

            $order = 0;

            foreach ($blocks as $blk) {
                $block = new Block();
                $block->blockable_id = $webArticle->id;
                $block->blockable_type = 'App\Models\DigitalPublicationArticle';

                $block->position = $order;

                // TODO: Adapt Trevin's spec image code here
                if ($blk->type == 'figure') {
                    // $figText = '<span>'.$blk['figure_url'].'</span>';
                    $figText = '<figure><img src="' . $blk->figure_url . '" alt /><figcaption>' . $blk->figure_capt . '</figcaption></figure>';

                    $block->content = [ 'paragraph' => $figText ];
                } else {
                    $block->content = [ 'paragraph' => $blk->html ];
                }

                $block->type = 'paragraph';
                $block->save();

                $webArticle->blocks()->save($block);

                $order += 1;
            }

            $webArticle->save();
            $webPub->articles()->save($webArticle);
        }

        $webPub->save();
    }
}
