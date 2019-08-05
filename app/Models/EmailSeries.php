<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

class EmailSeries extends AbstractModel implements Sortable
{
    use Transformable;
    use HasPosition;

    protected $fillable = [
        'title',
        'timing_message',
        'alert_message',
        'show_affiliate',
        'show_member',
        'show_sustaining_fellow',
        'show_nonmember',
        'use_short_description',
        'position',
        'published',
    ];

    public $checkboxes = [
        'show_affiliate',
        'show_member',
        'show_sustaining_fellow',
        'show_nonmember',
        'use_short_description',
        'published',
    ];

    public $casts = [
        'show_affiliate' => 'boolean',
        'show_member' => 'boolean',
        'show_sustaining_fellow' => 'boolean',
        'show_nonmember' => 'boolean',
        'use_short_description' => 'boolean',
        'published' => 'boolean',
    ];

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'title',
                'doc' => 'Name of this email series',
                'type' => 'string',
                'value' => function () {return $this->title;},
            ],
            [
                "name" => 'timing_message',
                'doc' => 'Notice regarding how often this email series is sent',
                'type' => 'string',
                'value' => function () {return $this->timing_message;},
            ],
            [
                "name" => 'alert_message',
                'doc' => 'Custom notice to display above the copy selection options',
                'type' => 'string',
                'value' => function () {return $this->alert_message;},
            ],
            [
                "name" => 'show_affiliate',
                'doc' => 'Whether to show the "Include affiliate-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_affiliate;},
            ],
            [
                "name" => 'show_member',
                'doc' => 'Whether to show the "Include member-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_member;},
            ],
            [
                "name" => 'show_sustaining_fellow',
                'doc' => 'Whether to show the "Include sustaining fellow-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_sustaining_fellow;},
            ],
            [
                "name" => 'show_nonmember',
                'doc' => 'Whether to show the "Include nonmember-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_nonmember;},
            ],
            [
                "name" => 'use_short_description',
                'doc' => 'Whether to use the event short description as the default copy',
                'type' => 'boolean',
                'value' => function () {return $this->use_short_description;},
            ],
        ];
    }

}
