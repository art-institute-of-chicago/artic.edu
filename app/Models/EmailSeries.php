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
        'luminary' => 'luminary',
        'nonmember' => 'nonmember',
    ];

    protected $fillable = [
        'title',
        'timing_message',
        'alert_message',
        'show_affiliate',
        'show_member',
        'show_luminary',
        'show_nonmember',
        'show_affiliate_test',
        'show_member_test',
        'show_luminary_test',
        'show_nonmember_test',
        'position',
        'published',
    ];

    public $checkboxes = [
        'show_affiliate',
        'show_member',
        'show_luminary',
        'show_nonmember',
        'show_affiliate_test',
        'show_member_test',
        'show_luminary_test',
        'show_nonmember_test',
        'published',
    ];

    public $casts = [
        'show_affiliate' => 'boolean',
        'show_member' => 'boolean',
        'show_luminary' => 'boolean',
        'show_nonmember' => 'boolean',
        'show_affiliate_test' => 'boolean',
        'show_member_test' => 'boolean',
        'show_luminary_test' => 'boolean',
        'show_nonmember_test' => 'boolean',
        'published' => 'boolean',
    ];

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'title',
                'doc' => 'Name of this email series',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],
            [
                'name' => 'timing_message',
                'doc' => 'Notice regarding how often this email series is sent',
                'type' => 'string',
                'value' => function () {
                    return $this->timing_message;
                },
            ],
            [
                'name' => 'alert_message',
                'doc' => 'Custom notice to display above the copy selection options',
                'type' => 'string',
                'value' => function () {
                    return $this->alert_message;
                },
            ],
            [
                'name' => 'show_affiliate',
                'doc' => 'Whether to show the "Include affiliate-specific copy" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_affiliate;
                },
            ],
            [
                'name' => 'show_member',
                'doc' => 'Whether to show the "Include member-specific copy" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_member;
                },
            ],
            [
                'name' => 'show_luminary',
                'doc' => 'Whether to show the "Include luminary-specific copy" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_luminary;
                },
            ],
            [
                'name' => 'show_nonmember',
                'doc' => 'Whether to show the "Include nonmember-specific copy" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_nonmember;
                },
            ],
            [
                'name' => 'show_affiliate_test',
                'doc' => 'Whether to show the "Send affiliate test" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_affiliate_test;
                },
            ],
            [
                'name' => 'show_member_test',
                'doc' => 'Whether to show the "Send member test" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_member_test;
                },
            ],
            [
                'name' => 'show_luminary_test',
                'doc' => 'Whether to show the "Send luminary test" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_luminary_test;
                },
            ],
            [
                'name' => 'show_nonmember_test',
                'doc' => 'Whether to show the "Send nonmember test" option',
                'type' => 'boolean',
                'value' => function () {
                    return $this->show_nonmember_test;
                },
            ],
        ];
    }
}
