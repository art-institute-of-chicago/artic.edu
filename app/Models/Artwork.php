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
use Illuminate\Database\Eloquent\Relations\Relation;

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
    ];

    public $attributes = [
        'default_manifest_url' => false,
        'toggle_autorelated' => false,
        'toggle_autopublications' => false,
        'toggle_autoexhibitions' => false,
        'toggle_autoeducator_resources' => false,
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
     * Exhibitions selected by hand in the artwork's Exhibitions browser.
     *
     * @return \Illuminate\Support\Collection
     */
    public function manualExhibitions()
    {
        return $this->getRelatedWithApiModels('artwork_exhibitions', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitionsEvents',
                'moduleName' => 'exhibitions',
            ],
        ], [
            'exhibitions' => true,
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
     * Items curated by hand in the artwork's Multimedia browser.
     *
     * Each entry is `['type' => <morph alias>, 'model' => <model>]`. Layered
     * image viewer blocks are resolved through their snapshot clones.
     *
     * @return \Illuminate\Support\Collection
     */
    public function multimediaItems()
    {
        return $this->relatedItems()
            ->where('browser_name', 'artwork_multimedia')
            ->orderBy('position')
            ->get()
            ->map(function ($related) {
                if ($related->related_type === 'blocks') {
                    $model = \App\Models\Vendor\Block::find($related->related_id);
                } else {
                    $class = Relation::getMorphedModel($related->related_type) ?? $related->related_type;
                    $model = class_exists($class) ? $class::find($related->related_id) : null;
                }

                if (!$model) {
                    return null;
                }

                return [
                    'type' => $related->related_type,
                    'model' => $model,
                ];
            })
            ->filter()
            ->values();
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
