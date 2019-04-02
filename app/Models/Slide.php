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

class Slide extends Model implements Sortable
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'experience_id',
        'asset_type',
        'module_type',
        'media_type',
        'media_title',
        'position',
        'attributes',
        'headline',
        'image_side',
        'caption',
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

    public $filesParams = ['sequence_file'];

    public function getAttributesAttribute()
    {
        if ($this->attributes['attributes']) {
            return array_map(function ($option) {
                return ['id' => $option];
            }, json_decode($this->attributes['attributes']));
        }
    }

    public function primaryExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'slide_primary_experience_image');
    }

    public function secondaryExperienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'slide_secondary_experience_image');
    }

    public function primaryExperienceModal()
    {
        return $this->morphMany('App\Models\ExperienceModal', 'modalble')->where('modalble_repeater_name', 'primary_experience_modal');
    }

    public function secondaryExperienceModal()
    {
        return $this->morphMany('App\Models\ExperienceModal', 'modalble')->where('modalble_repeater_name', 'secondary_experience_modal');
    }

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
}
