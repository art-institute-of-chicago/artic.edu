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
        'affiliate_copy',
        'show_member',
        'member_copy',
        'show_sustaining_fellow',
        'sustaining_fellow_copy',
        'show_nonmember',
        'nonmember_copy',
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
                "name" => 'affiliate_copy',
                'doc' => 'Default copy for emails to Affiliate Members',
                'type' => 'string',
                'value' => function () {return $this->affiliate_copy;},
            ],
            [
                "name" => 'show_member',
                'doc' => 'Whether to show the "Include member-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_member;},
            ],
            [
                "name" => 'member_copy',
                'doc' => 'Default copy for emails to Members',
                'type' => 'string',
                'value' => function () {return $this->member_copy;},
            ],
            [
                "name" => 'show_sustaining_fellow',
                'doc' => 'Whether to show the "Include sustaining fellow-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_sustaining_fellow;},
            ],
            [
                "name" => 'sustaining_fellow_copy',
                'doc' => 'Default copy for emails to Sustaining Fellows',
                'type' => 'string',
                'value' => function () {return $this->sustaining_fellow_copy;},
            ],
            [
                "name" => 'show_nonmember',
                'doc' => 'Whether to show the "Include nonmember-specific copy" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_nonmember;},
            ],
            [
                "name" => 'nonmember_copy',
                'doc' => 'Default copy for emails to Nonmembers',
                'type' => 'string',
                'value' => function () {return $this->nonmember_copy;},
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
