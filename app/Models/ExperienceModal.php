<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class ExperienceModal extends Model implements Sortable
{
    use HasBlocks, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'position',
        'modal_type',
        'zoomable',
        'video_play_settings',
        'video_playback',
        'video_url',
        'image_sequence_playback',
        'image_sequence_caption',
        'modalble_type',
        'modalble_id',
        'modalble_repeater_name',
        'title',
        'youtube_url',
        'alt_text',
        'inline_credits',
        'credits_input',
        'object_id',
        'artist',
        'credit_title',
        'credit_date',
        'medium',
        'dimensions',
        'credit_line',
        'main_reference_number',
        'copyright_notice',
    ];

    // uncomment and modify this as needed if you use the HasTranslation trait
    // public $translatedAttributes = [
    //     'title',
    //     'description',
    //     'active',
    // ];

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

    public function experienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'experience_image');
    }

    public function toRepeaterArray()
    {
        $fields = $this->attributesToArray();
        $fields['video_play_settings'] = json_decode($fields['video_play_settings']) ?? [];
        $fields['video_playback'] = json_decode($fields['video_playback']) ?? [];
        $fields['image_sequence_playback'] = json_decode($fields['image_sequence_playback']) ?? [];
        return $fields;
    }
}
