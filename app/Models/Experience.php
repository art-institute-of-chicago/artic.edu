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
        'attract_title',
        'attract_subhead',
        'media_title',
        'end_credit_subhead',
        'end_credit_copy',
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

    public function slides()
    {
        return $this->hasMany('App\Models\Slide', 'experience_id');
    }

    public function digitalLabel()
    {
        return $this->belongsTo('App\Models\DigitalLabel');
    }

    public function attractExperienceImages()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'attract_experience_image');
    }

    public function endExperienceImages()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'end_experience_image');
    }

    public function endBackgroundExperienceImages()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'end_bg_experience_image');
    }

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    public function scopeUnarchived($query)
    {
        return $query->where('archived', false);
    }
}
