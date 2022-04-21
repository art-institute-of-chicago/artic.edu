<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Behaviors\HasMedias;
use App\Helpers\StringHelpers;

class Artwork extends AbstractModel
{
    use HasApiModel, HasRelated, HasApiRelations, HasFeaturedRelated, HasMedias, HasFiles;

    protected $apiModel = 'App\Models\Api\Artwork';

    protected $fillable = [
        'datahub_id',
        'meta_title',
        'meta_description',
        'default_manifest_url',
        'default_view',
        'artwork_website_url',
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

    public $checkboxes = ['default_manifest_url'];

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
}
