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
        'video_url',
        'image_sequence_playback',
        'image_sequence_caption',
        'modalble_type',
        'caption',
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

    public $checkboxes = [
        'published',
    ];

    protected $casts = [
        'video_play_settings' => 'array',
        'image_sequence_playback' => 'array'
    ];

    public function experienceImage()
    {
        return $this->morphMany('App\Models\ExperienceImage', 'imagable')->where('imagable_repeater_name', 'modal_experience_image');
    }
}
