<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;

class ExperienceImage extends Model implements Sortable
{
    use HasBlocks, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'position',
        'inline_credits',
        'credits_input',
        'object_id',
        'artist',
        'caption',
        'credit_title',
        'credit_date',
        'medium',
        'dimensions',
        'credit_line',
        'main_reference_number',
        'copyright_notice',
        'imagable_type',
        'imagable_id',
        'imagable_repeater_name',
    ];

    public $checkboxes = [
        'published',
    ];
}
