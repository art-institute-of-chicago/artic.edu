<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Behaviors\HasAutoRelated;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Api\TextEmbedding;
use App\Models\Api\ImageEmbedding;
use App\Helpers\StringHelpers;

class Artwork extends AbstractModel
{
    use HasApiModel;
    use Transformable;
    use HasRelated;
    use HasApiRelations;
    use HasFeaturedRelated;
    use HasAutoRelated;
    use HasBlocks;
    use HasMedias;
    use HasFiles;

    protected $apiModel = 'App\Models\Api\Artwork';

    protected $fillable = [
        'datahub_id',
        'meta_title',
        'meta_description',
        'default_manifest_url',
        'default_view',
        'artwork_website_url',
        'toggle_autorelated',
        'toggle_autopublications',
        'toggle_autoexhibitions',
        'toggle_autoeducator_resources',
        'related_content_title',
        'related_content_description',
        'override_related_content_title',
        'publications_title',
        'publications_description',
        'override_publications_title',
        'exhibitions_title',
        'exhibitions_description',
        'override_exhibitions_title',
        'educator_resources_title',
        'educator_resources_description',
        'override_educator_resources_title',
        'view_360_title',
        'view_360_description',
        'override_view_360_title',
        'view_3d_title',
        'view_3d_description',
        'override_view_3d_title',
    ];

    public $mediasParams = [
        'iiif' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 'default',
                ],
            ]
        ],
    ];

    public $filesParams = ['image_sequence_file', 'upload_manifest_file'];

    public $casts = [
        'default_manifest_url' => 'boolean',
        'toggle_autorelated' => 'boolean',
        'toggle_autopublications' => 'boolean',
        'toggle_autoexhibitions' => 'boolean',
        'toggle_autoeducator_resources' => 'boolean',
        'override_related_content_title' => 'boolean',
        'override_publications_title' => 'boolean',
        'override_exhibitions_title' => 'boolean',
        'override_educator_resources_title' => 'boolean',
        'override_view_360_title' => 'boolean',
        'override_view_3d_title' => 'boolean',
    ];

    public $attributes = [
        'default_manifest_url' => false,
        'toggle_autorelated' => false,
        'toggle_autopublications' => false,
        'toggle_autoexhibitions' => false,
        'toggle_autoeducator_resources' => false,
        'override_related_content_title' => false,
        'override_publications_title' => false,
        'override_exhibitions_title' => false,
        'override_educator_resources_title' => false,
        'override_view_360_title' => false,
        'override_view_3d_title' => false,
    ];

    public function getFullTitleAttribute()
    {
        return $this->title;
    }

    /**
     * Publications selected by hand in the artwork's Publications browser.
     *
     * @return \Illuminate\Support\Collection
     */
    public function manualPublications()
    {
        return $this->getRelatedWithApiModels('artwork_publications', [], [
            'digitalPublications' => false,
            'printedPublications' => false,
            'digitalPublicationArticles' => false,
        ]) ?? collect([]);
    }

    /**
     * Educator Resources selected by hand in the artwork's Educator Resources
     * browser.
     *
     * @return \Illuminate\Support\Collection
     */
    public function manualEducatorResources()
    {
        return $this->getRelatedWithApiModels('artwork_educator_resources', [], [
            'educatorResources' => false,
        ]) ?? collect([]);
    }

    public function model3d()
    {
        return $this->belongsTo('App\Models\Model3d', '3d_model_id');
    }

    /**
     * The artwork's Multimedia blocks, in curated order.
     *
     * Each block selects one item (interactive feature, digital explorer, or
     * layered image viewer block) and may override that item's section title and
     * description.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function multimediaItemBlocks()
    {
        return $this->blocks()
            ->whereNull('parent_id')
            ->where('type', 'multimedia_item')
            ->orderBy('position')
            ->get();
    }

    public function getTrackingTitleAttribute()
    {
        return $this->title;
    }

    public function getSlugAttribute(): string
    {
        return StringHelpers::getUtf8Slug($this->title);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('twill.collection.artworks.edit', $this->id);
    }

    /**
     * The main artist's tag page, exposed as a Related Content sidebar item.
     *
     * The artist relations live on the API model, so delegate to it (using the
     * already-loaded API model when available to avoid a duplicate request).
     *
     * @return \App\Models\Api\Artist|null
     */
    public function getRelatedArtistPageAttribute()
    {
        $apiModel = $this->getApiModelFilledCached();

        if (!$apiModel) {
            return null;
        }

        if (!method_exists($apiModel, 'getRelatedArtistPageAttribute')) {
            return null;
        }

        // Call the accessor directly: going through `__get` would fall back to
        // this model again (and duplicate the API request) when the result is
        // null.
        return $apiModel->getRelatedArtistPageAttribute();
    }

    public function getAssetLibraryAttribute()
    {
        // Include image sequence
        if ($this->fileObject('image_sequence_file')) {
            $images = SeamlessImage::where('zip_file_id', $this->fileObject('image_sequence_file')->id)->get();
            $asset = [
                'type' => 'sequence',
                'id' => $this->fileObject('image_sequence_file')->id,
                'width' => $images->first() ? $images->first()->width : 0,
                'height' => $images->first() ? $images->first()->height : 0,
                'src' => $images->map(function ($image) {
                    return [
                        'src' => 'https://' . config('twill.imgix_source_host') . '/seq/' . $image->file_name,
                        'frame' => $image->frame,
                    ];
                })->toArray(),
            ];

            return $asset;
        }

        return null;
    }

    public function getMiradorManifest()
    {
        if ($this->default_manifest_url or $this->file('upload_manifest_file')) {
            if ($this->file('upload_manifest_file')) {
                $manifestFile = $this->file('upload_manifest_file');
            } else {
                $manifestFile = config('api.public_uri') . '/api/v1/artworks/' . $this->datahub_id . '/manifest.json';
            }

            return $manifestFile;
        }

        return null;
    }

    public function getMiradorView()
    {
        return $this->default_view;
    }

    public function getSemanticSearchDescriptionAttribute()
    {
        return $this->textEmbeddingData->data['description'];
    }

    public function imageEmbeddingData()
    {
        return $this->hasOne(ImageEmbedding::class, 'model_id', 'datahub_id')
                    ->where('model_name', 'artworks');
    }

    public function textEmbeddingData()
    {
        return $this->hasOne(TextEmbedding::class, 'model_id', 'datahub_id')
                    ->where('model_name', 'artworks');
    }
    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'datahub_id',
                'doc' => 'Data Hub ID',
                'type' => 'string',
                'value' => function () {
                    return $this->datahub_id;
                },
            ],
            [
                'name' => 'has_advanced_imaging',
                'doc' => 'Has 360 photography, 3D model, etc.',
                'type' => 'boolean',
                'value' => function () {
                    // ART-66: For now, limit this to 360 imagery
                    return false
                        || $this->files()
                            ->wherePivotIn('role', [
                                'image_sequence_file',
                                // 'upload_manifest_file',
                            ])
                            ->exists()
                        // || $this->model3d()->exists()
                        // || (bool) $this->default_manifest_url
                    ;
                },
            ],
        ];
    }
}
