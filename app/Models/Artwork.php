<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Behaviors\HasAutoRelated;
use App\Models\Behaviors\HasMedias;
use App\Helpers\StringHelpers;

class Artwork extends AbstractModel
{
    use HasApiModel;
    use Transformable;
    use HasRelated;
    use HasApiRelations;
    use HasFeaturedRelated;
    use HasAutoRelated;
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
    ];

    public $attributes = [
        'default_manifest_url' => false,
        'toggle_autorelated' => false,
    ];

    public function getFullTitleAttribute()
    {
        return $this->title;
    }

    public function model3d()
    {
        return $this->belongsTo('App\Models\Model3d', '3d_model_id');
    }

    public function getTrackingTitleAttribute()
    {
        return $this->title;
    }

    public function getSlugAttribute()
    {
        return ['en' => StringHelpers::getUtf8Slug($this->title)];
    }

    public function getAdminEditUrlAttribute()
    {
        return route('twill.collection.artworks.edit', $this->id);
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
