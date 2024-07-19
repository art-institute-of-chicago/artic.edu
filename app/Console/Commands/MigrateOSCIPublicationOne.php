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
     * mediaFactory
     *
     * Fetches asset for this figure layer and registers it as Media,
     * applying caption and using OSCI's fallback URL
     *
     * @param imageData - JSON of image data for this layer
     * @param caption_html - HTML of caption data
     * @param fallback_url - Fallback image to use for this layer
     *
     */
    private function mediaFactory($imageData, $caption_html, $fallback_url)
    {
        $imageUrl;
        switch ($imageData["type"]) {
            // TODO: Use s3 URLs instead
            // case "iip":
            //     $imageUrl = $imageData["image_url_stem"] . '?fif=' . $imageData["image_ident"] . '&cvt=jpeg' ;
            //     break;

            case "image":
                $imageUrl = $imageData["static_url"];
                break;

            case "svg":
                $imageUrl = $imageData["svg_path"];
                break;

            default:
                $imageUrl = $fallback_url;
                break;
        }

        // TODO: Load JPEG-converted PTIFF URL from this from db's `assets` table
        // TODO: Load 360-zip URL from this from db's `assets` table

        // Construct the UUID for this asset and preserve filename info
        $imageUuid = (string) Str::uuid();
        $imageUrlPath = parse_url($imageUrl, PHP_URL_PATH);
        $imageFilename = pathinfo($imageUrlPath, PATHINFO_FILENAME);
        $imageFilename = Str::random(10) . '-' . sanitizeFilename($imageFilename);

        $imageName = $imageUuid . '/' . $imageFilename;

        $http_ctx = stream_context_create(array(
                        'http' => [
                            'timeout' => 120,
                            'ignore_errors' => true,
                        ]
                    ));

        $imageContent = false;
        $retries = 0;

        while (!$imageContent && $retries < 5) {
            $imageContent = file_get_contents($imageUrl, false, $http_ctx);
            $retries++;
            usleep(20);
        }

        if (!$imageContent) {
            echo "Error could not fetch {$imageUrl} after {$retries} attempts! This media won't be migrated";
            return null;
        }

        if ($imageData['type'] == 'svg') {
            $width = ceil($imageData['width']);
            $height = ceil($imageData['height']);
        } else {
            [$width, $height] = getimagesizefromstring($imageContent);
        }

        Storage::disk('s3')->put($imageName, $imageContent);

        $media = new Media([
                    'uuid' => $imageName,
                    'width' => $width,
                    'height' => $height,
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

        $layers = isset($figure->layers_data) ? json_decode($figure->layers_data, true) : [];

        switch (true) {
            // Non-video embeds (HTML, mostly) become media_embed
            case $figure->figure_type === 'html_figure' && !isset($figure->html_content_src):
                $block->type = 'media_embed';
                $block->content = [
                    "size" => "s",
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
                    "size" => "s",
                    "media_type" => "youtube",
                    "url" => $figure->html_content_src
                ];
                $block->save();

                break;

            // OSCI's layered_image with only one layer should just be an image
            case 'layered_image' && count($layers) === 1:
                $block->type = 'image';
                $block->content = [
                  "is_modal" => false,
                  "is_zoomable" => false,
                  "size" => "s",
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
                if ($media === null) {
                    break;
                }

                // TODO: Use converted crop params
                $block->medias()->attach($media->id, [
                    'locale' => 'en',
                    'media_id' => $media->id,
                    'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                    'role' => 'image',
                    'crop' => 'desktop',
                    'crop_x' => 0,
                    'crop_y' => 0,
                    'crop_w' => $media->width,
                    'crop_h' => $media->height
                ]);

                $block->save();
                break;

            case 'layered_image':
                $block->type = 'layered_image_viewer';
                $block->editor_name = 'default';
                $block->content = [
                  "size" => "s",
                  "caption" => $figure->caption_html,
                ];

                $block->save();

                $figure_opts = json_decode($figure->figure_opts, true);

                $imageLayerIds = $figure_opts['baseLayerPreset'] ?? [];
                $overlayLayerIds = $figure_opts['annotationPreset'] ?? [];

                foreach ($layers as $imageData) {
                    // Each layer (image or overlay) is a child block of the layered image viewer block, so:
                    // - Create media record + move the asset (if not moved already)
                    // - Configure a layer block for this layer (image or overview)
                    // - Attach it to the layer viewer block

                    $layer_id = $imageData;

                    $layerBlock = new Block();
                    $layerBlock->blockable_id = $block->blockable_id;
                    $layerBlock->blockable_type =  'digitalPublicationArticles';
                    $layerBlock->parent_id = $block->id;

                    // Configure this as an image or overlay and set position
                    // TODO: Check the extension as PNGs appear to be overlays as well
                    if ($imageData['type'] == 'svg') {
                        $layerBlock->child_key = 'layered_image_viewer_overlay';
                        $layerBlock->type = 'layered_image_viewer_overlay';
                    } else {
                        $layerBlock->child_key = 'layered_image_viewer_img';
                        $layerBlock->type = 'layered_image_viewer_img';
                    }

                    $layerBlock->position = $imageData['layer_num'];

                    $layerBlock->content = [
                      "label" => $imageData['title']
                    ];

                    $layerBlock->save();

                    $media = $this->mediaFactory($imageData, $figure->caption_html, $figure->fallback_url);
                    if ($media !== null) {
                        // TODO: Use converted crop params
                        $layerBlock->medias()->attach($media->id, [
                            'locale' => 'en',
                            'media_id' => $media->id,
                            'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                            'role' => 'image',
                            'crop' => 'desktop',
                            'crop_x' => 0,
                            'crop_y' => 0,
                            'crop_w' => $media->width,
                            'crop_h' => $media->height
                        ]);
                        $layerBlock->save();
                    }

                    $block->children()->save($layerBlock);
                    $block->save();
                }

                $block->save();
                break;

            case 'iip_asset':
                $block->type = 'image';
                $block->content = [
                  "is_modal" => false,
                  "is_zoomable" => false,
                  "size" => "s",
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
                if ($media === null) {
                    break;
                }

                // TODO: Use converted crop params
                $block->medias()->attach($media->id, [
                    'locale' => 'en',
                    'media_id' => $media->id,
                    'metadatas' => '{"caption":null,"captionTitle": null, "altText":null,"video":null}',
                    'role' => 'image',
                    'crop' => 'desktop',
                    'crop_x' => 0,
                    'crop_y' => 0,
                    'crop_w' => $media->width,
                    'crop_h' => $media->height
                ]);

                $block->save();
                break;

            case '360_slider':
                $block->type = '360_embed';
                $block->content = [
                    "size" => "s",
                    "caption" => $figure->caption_html
                ];

                // TODO: use this->mediaFactory to fetch + attach 360 zip
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
        // TODO: webPub->header_title_display = italicized OSCI title
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
WITH layers (layers_url,figure_opts,layers_data) AS (
    SELECT json_extract(figure_layers.data,'$._asset_url') AS layers_url,
            coalesce(json_extract(figure_layers.data,'$.options'),'{}') AS figure_opts,
        json_group_array(
            json_object(
                'type',json_extract(layers.value,'$._type'),
                'layer_id',json_extract(layers.value,'$._layer_id'),
                'layer_num',json_extract(layers.value,'$._layer_num'),
                'static_url',json_extract(layers.value,'$._static_url'),
                'svg_path',json_extract(layers.value,'$._svg_path'),
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
                  layers.figure_opts AS figure_opts,
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

            $heroMedia = false;
            $heroMediaArray = [];

            foreach ($blocks as $blk) {
                $block = new Block();
                $block->blockable_id = $webArticle->id;
                $block->blockable_type = 'App\Models\DigitalPublicationArticle';

                $block->position = $order;

                $this->configureBlock($blk, $block);

                // If this is the first image block, save the image to add as the article hero image later
                if ($block->type == 'image' && !$heroMedia) {
                    $heroMedia = $block->medias->first();
                    if ($heroMedia) {
                        $heroMediaArray['locale'] = 'en';
                        $heroMediaArray['role'] = 'hero';
                        $heroMediaArray['media_id'] = $heroMedia->pivot->media_id;
                        $heroMediaArray['metadatas'] = $heroMedia->pivot->metadatas;
                        $heroMediaArray['crop'] = 'default';
                        $heroMediaArray['crop_x'] = $heroMedia->pivot->crop_x;
                        $heroMediaArray['crop_y'] = $heroMedia->pivot->crop_y;
                        $heroMediaArray['crop_w'] = $heroMedia->pivot->crop_w;
                        $heroMediaArray['crop_h'] = $heroMedia->pivot->crop_h;
                    }
                }
                $webArticle->blocks()->save($block);

                $order += 1;
            }

            $webArticle->save();

            // If we grabbed an image to use for the hero, save it
            if ($heroMedia) {
                $webArticle->medias()->attach($heroMedia->id, $heroMediaArray);
                $webArticle->save();
            }

            $webPub->articles()->save($webArticle);
        }

        $webPub->save();
    }
}
