<?php

namespace App\Models;

use A17\Twill\Models\Model;

class EmailSeries extends Model
{
    protected $fillable = [
        'title',
        'show_affiliate_member',
        'affiliate_member_copy',
        'show_member',
        'member_copy',
        'show_sustaining_fellow',
        'sustaining_fellow_copy',
        'show_non_member',
        'non_member_copy',
    ];

    public $checkboxes = [
        'show_affiliate_member',
        'show_member',
        'show_sustaining_fellow',
        'show_non_member',
        'published',
    ];
}
