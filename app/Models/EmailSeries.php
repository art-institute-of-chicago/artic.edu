<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

class EmailSeries extends AbstractModel implements Sortable
{
    use Transformable;
    use HasPosition;

    /**
     * Key is for field names, value is for labels.
     */
    public static $memberTypes = [
        'affiliate' => 'affiliate',
        'member' => 'member',
        'sustaining_fellow' => 'sustaining fellow',
        'nonmember' => 'nonmember',
    ];

    protected $fillable = [
        'title',
        'timing_message',
        'alert_message',
        'show_affiliate',
        'show_member',
        'show_sustaining_fellow',
        'show_nonmember',
        'show_affiliate_test',
        'show_member_test',
        'show_sustaining_fellow_test',
        'show_nonmember_test',
        'position',
        'published',
    ];

    public $checkboxes = [
        'show_affiliate',
        'show_member',
        'show_sustaining_fellow',
        'show_nonmember',
        'show_affiliate_test',
        'show_member_test',
        'show_sustaining_fellow_test',
        'show_nonmember_test',
        'published',
    ];

    public $casts = [
        'show_affiliate' => 'boolean',
        'show_member' => 'boolean',
        'show_sustaining_fellow' => 'boolean',
        'show_nonmember' => 'boolean',
        'show_affiliate_test' => 'boolean',
        'show_member_test' => 'boolean',
        'show_sustaining_fellow_test' => 'boolean',
        'show_nonmember_test' => 'boolean',
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
                "name" => 'show_affiliate_test',
                'doc' => 'Whether to show the "Send affiliate test" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_affiliate_test;},
            ],
            [
                "name" => 'show_member_test',
                'doc' => 'Whether to show the "Send member test" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_member_test;},
            ],
            [
                "name" => 'show_sustaining_fellow_test',
                'doc' => 'Whether to show the "Send sustaining fellow test" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_sustaining_fellow_test;},
            ],
            [
                "name" => 'show_nonmember_test',
                'doc' => 'Whether to show the "Send nonmember test" option',
                'type' => 'boolean',
                'value' => function () {return $this->show_nonmember_test;},
            ],
        ];
    }

}
