<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Page::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
        'published' => $faker->boolean,
        'position' => $faker->randomDigit,
        'title' => $faker->sentence(3),
        'type' => $faker->randomDigit,
        'visit_intro' => $faker->paragraph(3),
        'home_intro' => $faker->paragraph(3),
        'exhibition_intro' => $faker->paragraph(3),
        'art_intro' => $faker->paragraph(3),
        'exhibition_history_sub_heading' => $faker->paragraph(3),
        'exhibition_history_intro_copy' => $faker->paragraph(3),
        'exhibition_history_popup_copy' => $faker->paragraph(3),
        'home_membership_module_url' => $faker->url,
        'home_membership_module_headline' => $faker->sentence(8),
        'home_membership_module_short_copy' => $faker->paragraph(3),
        'home_membership_module_button_text' => $faker->sentence(3),
        'visit_hour_header' => $faker->sentence(10),
        'visit_hour_subheader' => $faker->sentence(10),
        'visit_city_pass_title' => $faker->sentence(5),
        'visit_city_pass_text' => $faker->paragraph(2),
        'visit_city_pass_button_label' => $faker->sentence(3),
        'visit_city_pass_link' => $faker->url,
        'visit_transportation_link' => $faker->url,
        'visit_parking_link' => $faker->url,
        'visit_admission_description' => $faker->paragraph(3),
        'visit_buy_tickets_label' => $faker->sentence(3),
        'visit_buy_tickets_link' => $faker->url,
        'visit_become_member_label' => $faker->sentence(3),
        'visit_become_member_link' => $faker->url,
        'visit_faq_accessibility_link' => $faker->url,
        'visit_faq_more_link' => $faker->url,
        'printed_catalogs_intro' => $faker->paragraph(3),
        'resources_landing_title' => $faker->sentence(8),
        'resources_landing_intro' => $faker->paragraph(3),
        'visit_dining_link' => $faker->url,
    ];
});
