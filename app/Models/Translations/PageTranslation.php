<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class PageTranslation extends Model
{
    protected $fillable = [
        'visit_intro',
        'visit_hour_header',
        'visit_hour_subheader',
        'visit_city_pass_title',
        'visit_city_pass_text',
        'visit_city_pass_button_label',
        'visit_admission_description',
        'visit_buy_tickets_label',
        'visit_become_member_label',
        'active',
        'locale',
    ];
}
