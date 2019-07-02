<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use App\Http\Resources\SlideAsset as SlideAssetResource;
use App\Http\Resources\Slide as SlideResource;
use App\Models\SeamlessImage;

class Experience extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'subtitle',
        'description',
        'position',
        'interactive_feature_id',
        'archived',
        'kiosk_only',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published',
    ];

    public function getContentBundleAttribute()
    {
        return SlideResource::collection($this->slides()->published()->orderBy('position')->get())->toArray(request());
    }

    public function getAssetLibraryAttribute()
    {
        // $slides = $this->slides()->published()->orderBy('position')->get()->filter(function ($slide) {
        //     $seamless_file = $slide->fileObject('sequence_file');
        //     return $seamless_file && SeamlessImage::where('zip_file_id', $seamless_file->id)->get()->count() > 0;
        // });
        $slides = $this->slides()->published()->orderBy('position')->get()->filter(function ($slide) {
            if ($slide->asset_type !== 'seamless') {
                return false;
            }

            if ($slide->media_type === 'type_image' && $slide->seamlessExperienceImage()->count() === 0) {
                return false;
            }

            if ($slide->media_type === 'seamless') {
                $seamless_file = $slide->fileObject('sequence_file');
                return $seamless_file && SeamlessImage::where('zip_file_id', $seamless_file->id)->get()->count() > 0;
            }

            return true;
        });
        return SlideAssetResource::collection($slides)->toArray(request());
    }

    public function imageFront() {
        if ($this->hasImage('thumbnail')) {
            $imageObject = $this->imageObject('thumbnail');
        } else {
            $attract_slide = $this->slides()->where('module_type', 'attract')->first();
            $attract_image = $attract_slide ? $attract_slide->attractExperienceImages()->first() : null;
            $imageObject = $attract_image ? $attract_image->imageObject('experience_image', 'default') : '';
        }

        if ($imageObject) {
            $cropParams = [
                'crop_x' => $imageObject->pivot->crop_x,
                'crop_y' => $imageObject->pivot->crop_y,
                'crop_w' => $imageObject->pivot->crop_w,
                'crop_h' => $imageObject->pivot->crop_h
            ];

            return aic_convertFromImage($imageObject, $cropParams);
        }
    }

    public function defaultCmsImage($params = [])
    {
        if ($this->hasImage('thumbnail')) {
            return $this->image('thumbnail');
        } else {
            $attract_slide = $this->slides()->where('module_type', 'attract')->first();
            $attract_image = $attract_slide ? $attract_slide->attractExperienceImages()->first() : null;
            return $attract_image ? $attract_image->cmsImage('experience_image', 'default', $params) : '';
        }
    }

    public function slides()
    {
        return $this->hasMany('App\Models\Slide', 'experience_id');
    }

    public function interactiveFeature()
    {
        return $this->belongsTo('App\Models\InteractiveFeature');
    }

    public function getTypeAttribute()
    {
        return 'experience';
    }

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    public function scopeUnarchived($query)
    {
        return $query->where('archived', false);
    }

    public function getUrl()
    {
        return route('interactiveFeatures.show', $this->slug);
    }

    public $mediasParams = [
        'thumbnail' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1 / 1,
                ],
            ],
        ]
    ];
}
