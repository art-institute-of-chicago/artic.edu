<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Repositories\Api\PublicationRepository;
use App\Models\DigitalPublication;
use App\Models\DigitalPublicationArticle;
use App\Models\Vendor\Block;
use A17\Twill\Models\Media;

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
     * configure $block (a Block model) with $data
     *
     */
    private function configureFigBlock($figure, $block)
    {
        switch ($figure->figure_type) {
            case 'html_figure':
                $block->type = 'media_embed';

                if (isset($figure->html_content_src)) {
                    $block->content = [
                        "size" => "m",
                        "embed_type" => "url",
                        "embed_url" => $figure->html_content_src,
                        "embed_height" => "400px",
                        "disable_placeholder" => true
                    ];

                } else {
                    $block->content = [
                        "size" => "m",
                        "embed_type" => "html",
                        "embed_code" => $figure->html_content,
                        "embed_height" => "400px",
                        "disable_placeholder" => true
                    ];                    
                }

                $block->save();

                break;

            case 'layered_image':
                $block->type = 'layered_image_viewer';

                // TODO: Instantiate the layers using fig_layer data, attaching each using fig_layer.data to get titles + layer # / order
                $block->content = [
                  "is_modal" => false,
                  "is_zoomable" => false,
                  "size" => "m",
                  "use_contain" => true,
                  "use_alt_background" => true,
                  "image_link" => null,
                  "hide_figure_number" => false,
                  "caption" => $figure->caption_html,
                  "alt_text" => ""
                ];

                $block->save();
                break;

            case 'iip_asset':
                $block->type = 'image';


                // Media uploads and relations
                $imagePath = isset($figure->static_url) ? $figure->static_url : $figure->fallback_url ;
                $imageUuid = (string) Str::uuid();
                $imageFilename = Str::random(10) . '.jpg';
                $imageName = $imageUuid . '/' . $imageFilename;

                Storage::disk('s3')->put($imageName, file_get_contents($imagePath));
                $block->content = [
                  "is_modal" => false,
                  "is_zoomable" => false,
                  "size" => "m",
                  "use_contain" => true,
                  "use_alt_background" => true,
                  "image_link" => null,
                  "hide_figure_number" => false,
                  "caption" => $figure->caption_html,
                  "alt_text" => ""
                ];

                $block->save();

                $media = new Media([
                            'uuid' => $imageName,
                            'width' => 2246,
                            'height' => 1469,
                            'filename' => $imageFilename,
                            'locale' => 'en'
                        ]);

                $media->alt_text = 'Alt text for the image';
                $media->caption = $figure->caption_html;
                $media->save();

                $block->medias()->attach($media->id, [
                    'locale' => 'en',
                    'media_id' => $media->id,
                    'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                    'role' => 'image',
                    'crop' => 'desktop',
                    'crop_x' => 0,
                    'crop_y' => 0,
                    'crop_w' => 2246,
                    'crop_h' => 1469
                ]);

                $block->save();
                break;

            case '360_slider':
                $block->type = '360_embed';
                $block->content = [ 
                    "size" => "m",
                    "caption" => $figure->caption_html
                ];

                // TODO: Attach media
                $block->save();
                break;

            case 'rti_viewer':
                // TODO: insert reader_url, figure # for this text + figure
                $block->type = 'video';
                $block->content = [ 
                    "caption" => $figure->caption_html
                ];

                $block->save();
                break;
        }
    }

    /**
     * configure $block (a Block model) with $data
     *
     * NB: "figure" here can be many different block types
     */
    private function configureBlock($data, $block)
    {
        switch ($data->type) {
            case 'figure':
                $this->configureFigBlock($data, $block);
                break;
            default:
                $block->content = [ 'paragraph' => $data->html ];
                $block->type = 'paragraph';
                break;
        }
    }

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

        $texts = DB::connection('osci_migration')->select("SELECT coalesce(json_extract(data,'$._title'),'FIXME') as title,text_id FROM texts WHERE package=:pubId", ['pubId' => $pubId]);

        // Initialize the left value
        $lft = 1;

        $blockQuery = "SELECT json_extract(blk.value,'$.html') AS html," .
                          "blk.id AS position," .
                          "json_extract(blk.value,'$.blockType') AS type," .
                          "json_extract(blk.value,'$.figure_type') AS figure_type," .
                          "json_extract(blk.value,'$.static_url') AS static_url," .
                          "json_extract(blk.value,'$.fallback_url') AS fallback_url," .
                          "json_extract(blk.value,'$.html_content') AS html_content," .
                          "json_extract(blk.value,'$.html_content_src') AS html_content_src," .
                          "coalesce(json_extract(blk.value,'$.caption_html'),'') AS caption_html " .
                          "FROM texts," .
                          "json_each(texts.data,'$.sections') AS sects," .
                          "json_each(sects.value,'$.blocks') AS blk " .
                          "WHERE texts.text_id=:textId";

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

            $blocks = DB::connection('osci_migration')->select($blockQuery, ['textId' => $text->text_id]);

            $order = 0;

            foreach ($blocks as $blk) {
                $block = new Block();
                $block->blockable_id = $webArticle->id;
                $block->blockable_type = 'App\Models\DigitalPublicationArticle';

                $block->position = $order;

                $this->configureBlock($blk, $block);

                $webArticle->blocks()->save($block);

                $order += 1;
            }

            $webArticle->save();
            $webPub->articles()->save($webArticle);
        }

        $webPub->save();
    }
}
