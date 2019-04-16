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
use App\Http\Resources\Slide as SlideResource;

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

    public function getContentBundleAttribute()
    {
        $slides = new SlideResource($this);
        // $attract_slide = [
        //     'id' => null,
        //     'type' => 'attract',
        //     'headline' => $this->attract_title,
        //     'subhead' => $this->attract_subhead,
        //     'media' => [],
        //     '__option_subhead' => !empty($this->attract_subhead),
        //     'seamlessAsset' => [],
        //     'assetType' => 'standard',
        //     '__mediaType' => null,
        //     'moduleTitle' => 'title',
        //     'exhibitionID' => null,
        //     'isActive' => true,
        //     'experienceId' => $this->id,
        //     'experienceType' => 'LABEL',
        //     'colorCode' => $this->digitalLabel->color,
        //     'bgColorCode' => $this->digitalLabel->grouping_background_color,
        //     'vScalePercent' => 0,
        // ];
        // $end_slide = [
        //     'id' => null,
        //     'headline' => $this->end_credit_subhead,
        //     'copy' => $this->end_credit_copy,
        //     'button' => 'Start Over',
        //     '__option_credits' => true,
        //     'modals' => [],
        //     'seamlessAsset' => [],
        //     'type' => 'end',
        //     'media' => [],
        //     '__option_background_image' => true,
        //     '__mediaType' => null,
        //     'assetType' => 'standard',
        //     'moduleTitle' => 'title',
        //     'exhibitionId' => null,
        //     'isActive' => true,
        //     'experienceId' => $this->id,
        //     'experienceType' => 'LABEL',
        //     'colorCode' => $this->digitalLabel->color,
        //     'bgColorCode' => $this->digitalLabel->grouping_background_color,
        //     'vScalePercent' => 0,
        // ];
        // $slides = array_prepend(SlideResource::collection($this->slides)->toArray(request()), $attract_slide);
        // array_push($slides, $end_slide);
        return $slides;
    }

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
