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
        'description',
        'position',
        'digital_label_id',
        'archived',
        'kiosk_only',
        // 'public',
        // 'featured',
        // 'publish_start_date',
        // 'publish_end_date',
    ];

    // uncomment and modify this as needed if you use the HasTranslation trait
    // public $translatedAttributes = [
    //     'title',
    //     'description',
    //     'active',
    // ];

    // uncomment and modify this as needed if you use the HasSlug trait
    public $slugAttributes = [
        'title',
    ];

    // add checkbox fields names here (published toggle is itself a checkbox)
    public $checkboxes = [
        'published',
    ];

    // uncomment and modify this as needed if you use the HasMedias trait
    // public $mediasParams = [
    //     'cover' => [
    //         'default' => [
    //             [
    //                 'name' => 'landscape',
    //                 'ratio' => 16 / 9,
    //             ],
    //             [
    //                 'name' => 'portrait',
    //                 'ratio' => 3 / 4,
    //             ],
    //         ],
    //         'mobile' => [
    //             [
    //                 'name' => 'mobile',
    //                 'ratio' => 1,
    //             ],
    //         ],
    //     ],
    // ];

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

    public function imageFront()
    {
        $attract_slide = $this->slides()->where('module_type', 'attract')->first();
        $attract_image = $attract_slide ? $attract_slide->attractExperienceImages()->first() : null;
        $image = $attract_image ? $attract_image->cmsImage('experience_image', 'default') : '';
        if (!empty($image)) {
            return [
                'src' => $image
            ];
        }
    }

    public function slides()
    {
        return $this->hasMany('App\Models\Slide', 'experience_id');
    }

    public function digitalLabel()
    {
        return $this->belongsTo('App\Models\DigitalLabel');
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
        return route('digitalLabels.show', $this->slug);
    }
}
