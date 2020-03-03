<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;

class ExperienceModal extends AbstractModel implements Sortable
{
    use HasBlocks, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'position',
        'modal_type',
        'zoomable',
        'video_play_settings',
        'image_sequence_playback',
        'image_sequence_caption',
        'modalble_type',
        'caption',
        'modalble_id',
        'modalble_repeater_name',
        'title',
        'video_url',
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

    public function toRepeaterArray()
    {
        $fields = $this->attributesToArray();
        $fields['image_sequence_playback'] = $fields['image_sequence_playback'] ?? [];
        $fields['video_play_settings'] = $fields['video_play_settings'] ?? [];
        return $fields;
    }

    public function model3d()
    {
        return $this->belongsTo('App\Models\Model3d', '3d_model_id');
    }
}
