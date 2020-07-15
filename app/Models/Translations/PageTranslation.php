<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class PageTranslation extends Model
{
    protected $fillable = [
        'visit_intro',
        'visit_hour_header',
        'visit_hour_subheader',
        'visit_hour_intro',
        'visit_city_pass_title',
        'visit_city_pass_text',
        'visit_city_pass_button_label',
        'visit_city_pass_link',
        'visit_admission_description',
        'visit_buy_tickets_label',
        'visit_become_member_label',
        'visit_accessibility_text',
        'visit_accessibility_link_text',
        'visit_cta_module_header',
        'visit_cta_module_body',
        'visit_cta_module_button_text',
        'visit_what_to_expect_more_text',
        'active',
        'locale',
    ];
}
