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

    private function mediaFactory($imageData, $caption_html, $fallback_url)
    {

        // Media uploads and relations
        $imageUrl = isset($imageData->static_url) ? $imageData->static_url : $fallback_url ;

        $imageUuid = (string) Str::uuid();
        $imageUrlPath = parse_url($imageUrl, PHP_URL_PATH);
        $imageExt = pathinfo($imageUrlPath, PATHINFO_EXTENSION);
        $imageFilename = Str::random(10) . $imageExt;

        $imageName = $imageUuid . '/' . $imageFilename;

        $ctx = stream_context_create(array(
                'http' =>
                    array(
                        'timeout' => 120,
                    )
                ));
        $imageContent = file_get_contents($imageUrl, false, $ctx);

        Storage::disk('s3')->put($imageName, $imageContent);

        // TODO: Use the CMS's onboard h/w helpers
        $media = new Media([
                    'uuid' => $imageName,
                    'width' => $imageData->width,
                    'height' => $imageData->height,
                    'filename' => $imageFilename,
                    'locale' => 'en'
                ]);

        $media->alt_text = 'Alt text for the image';
        $media->caption = $caption_html;
        $media->save();

        return $media;
    }
    /**
     * configure $block (a Block model) with $data
     *
     */
    private function configureFigBlock($figure, $block)
    {

        $layers = isset($figure->layers_data) ? json_decode($figure->layers_data) : [];

        // TODO: if html_figure and html_content_src, that's a video block bby
        switch (true) {
            // Non-video embeds (HTML, mostly) become media_embed
            case $figure->figure_type === 'html_figure' && !isset($figure->html_content_src):
                $block->type = 'media_embed';
                $block->content = [
                    "size" => "m",
                    "embed_type" => "html",
                    "embed_code" => $figure->html_content,
                    "embed_height" => "400px",
                    "disable_placeholder" => true,
                    "caption" => $figure->caption_html
                ];
                $block->save();

                break;

            // HTML embeds with a src are videos
            case $figure->figure_type === 'html_figure' && isset($figure->html_content_src):
                $block->type = 'video';

                $block->content = [
                    "size" => "m",
                    "media_type" => "youtube",
                    "url" => $figure->html_content_src
                ];
                $block->save();

                break;

            // OSCI's layered_image with only one layer should just be an image
            // TODO: Move IIP handling to a func and handle iip_asset in this `case`
            case 'layered_image' && count($layers) === 1:
                $block->type = 'image';
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

                $imageData = Arr::first($layers);
                $media = $this->mediaFactory($imageData, $figure->caption_html, $figure->fallback_url);

                // TODO: Use converted crop params
                $block->medias()->attach($media->id, [
                    'locale' => 'en',
                    'media_id' => $media->id,
                    'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                    'role' => 'image',
                    'crop' => 'desktop',
                    'crop_x' => 0,
                    'crop_y' => 0,
                    'crop_w' => $imageData->width,
                    'crop_h' => $imageData->height
                ]);

                $block->save();
                break;

            case 'layered_image':
                $block->type = 'layered_image_viewer';
                $block->editor_name = 'default';
                $block->content = [
                  "size" => "m",
                  "caption" => $figure->caption_html,
                ];

                $block->save();

                foreach ($layers as $imageData) {
                    // Each layer (image or overview) is a child block of the layered image viewer block, so:
                    // - Create media record + move the asset (if not moved already)
                    // - Configure a layer block for this layer (image or overview)
                    // - Attach it to the layer viewer block

                    $media = $this->mediaFactory($imageData, $figure->caption_html, $figure->fallback_url);

                    $layerBlock = new Block();
                    $layerBlock->blockable_id = $block->blockable_id;
                    $layerBlock->blockable_type =  'digitalPublicationArticles';
                    $layerBlock->position = 1; // TODO: order
                    $layerBlock->parent_id = $block->id;

                    // OSCI doesn't expose overlay vs image data so parse the URL filename
                    $imageUrl = isset($imageData->static_url) ? $imageData->static_url : $figure->fallback_url ;
                    $imageUrlPath = parse_url($imageUrl, PHP_URL_PATH);
                    $imageExt = pathinfo($imageUrlPath, PATHINFO_EXTENSION);

                    switch ($imageExt) {
                        case 'svg':
                            $layerBlock->child_key = 'layered_image_viewer_overlay';
                            $layerBlock->type = 'layered_image_viewer_overlay';
                            break;

                        default:
                            $layerBlock->child_key = 'layered_image_viewer_img';
                            $layerBlock->type = 'layered_image_viewer_img';
                            break;
                    }


                    $layerBlock->content = [
                      "label" => $imageData->title
                    ];

                    $layerBlock->save();

                    // TODO: Use converted crop params
                    $layerBlock->medias()->attach($media->id, [
                        'locale' => 'en',
                        'media_id' => $media->id,
                        'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                        'role' => 'image',
                        'crop' => 'desktop',
                        'crop_x' => 0,
                        'crop_y' => 0,
                        'crop_w' => $imageData->width,
                        'crop_h' => $imageData->height
                    ]);
                    $layerBlock->save();

                    $block->children()->save($layerBlock);
                    $block->save();
                }

                $block->save();
                break;

            case 'iip_asset':
                // TODO: Properly handle the IIP asset (finally!)
                $block->type = 'image';
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

                $imageData = Arr::first($layers);

                $media = $this->mediaFactory($imageData, $figure->caption_html, $figure->fallback_url);

                // TODO: Use converted crop params
                $block->medias()->attach($media->id, [
                    'locale' => 'en',
                    'media_id' => $media->id,
                    'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                    'role' => 'image',
                    'crop' => 'desktop',
                    'crop_x' => 0,
                    'crop_y' => 0,
                    'crop_w' => $imageData->width,
                    'crop_h' => $imageData->height
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

        // Fetch this publication's title by its package name (eg, `caillebotte`)
        // TODO: Handle italics / etc in the title
        // TODO: Set publication date metadata

        $pubs = DB::connection('osci_migration')->select("SELECT json_extract(publications.data,'$._title') as title FROM publications LEFT JOIN tocs ON tocs.package=publications.pub_id WHERE pub_id=:id", ['id' => $pubId]);
        $pub = Arr::first($pubs);

        $webPub = new DigitalPublication();
        $webPub->title = 'Migrated ' . date('M j, Y') . ' | ' . $pub->title;
        $webPub->published = false;
        $webPub->is_dsc_stub = false;
        $webPub->save();

        $webPubId = $webPub->id;

        // Now select all this pub's texts
        $texts = DB::connection('osci_migration')->select("SELECT coalesce(json_extract(data,'$._title'),'FIXME') as title,text_id FROM texts WHERE package=:pubId", ['pubId' => $pubId]);

        // Initialize the left value
        $lft = 1;

        // Fetch sections and blocks by text ID (joined to their figure assets)
        // NB: `layers_data` is a JSON array of layer asset objects

        // TODO: Add `toc_position`, `toc_parent` via json_tree against toc data
        $blockQuery = <<<EOT
WITH layers (layers_url,layers_data) AS (
    SELECT json_extract(figure_layers.data,'$._asset_url') AS layers_url,
        json_group_array(
            json_object(
                'layer_id',json_extract(layers.value,'$._layer_id'),
                'static_url',json_extract(layers.value,'$._static_url'),
                'image_ident',json_extract(layers.value,'$._image_ident'),
                'image_url_stem',json_extract(layers.value,'$._image_url_stem'),
                'title',coalesce(json_extract(layers.value,'$._title'),''),
                'height', json_extract(layers.value,'$._height'),
                'width', json_extract(layers.value,'$._width')
            )
        ) AS layers_data
    FROM figure_layers,
        json_each(figure_layers.data,'$.layers') as layers
    GROUP BY layers_url
)
SELECT json_extract(blk.value,'$.html') AS html,
                  blk.id AS position,
                  json_extract(blk.value,'$.blockType') AS type,
                  json_extract(blk.value,'$.figure_type') AS figure_type,
                  json_extract(blk.value,'$.fallback_url') AS fallback_url,
                  json_extract(blk.value,'$.html_content') AS html_content,
                  json_extract(blk.value,'$.html_content_src') AS html_content_src,
                  coalesce(json_extract(blk.value,'$.caption_html'),'') AS caption_html,
                  layers.layers_url AS layers_url,
                  layers.layers_data AS layers_data
                  FROM texts,
                  json_each(texts.data,'$.sections') AS sects,
                  json_each(sects.value,'$.blocks') AS blk
                    LEFT JOIN layers on json_extract(blk.value,'$.figure_layer_url')=layers.layers_url
                  WHERE texts.text_id=:textId
EOT;

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
