<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Event::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
        'published' => $faker->boolean,
        'content' => '[]',
        'title' => $faker->sentence(3),
        'admission' => null,
        'location' => $faker->sentence(3),
        'landing' => $faker->boolean,
        'rsvp_link' => $faker->url,
        'short_description' => $faker->paragraph(3),
        'hero_caption' => $faker->sentence(3),
        'description' => $faker->paragraph(5),
        'is_private' => $faker->boolean,
        'is_ticketed' => $faker->boolean,
        'is_free' => $faker->boolean,
        'sponsors_description' => $faker->paragraph(3),
        'hidden' => $faker->boolean,
        'layout_type' => $faker->randomDigit,
        'buy_button_text' => $faker->sentence(3),
        'buy_button_caption' => $faker->paragraph(3),
        'is_member_exclusive' => $faker->boolean,
        'is_sold_out' => $faker->boolean,
        'is_boosted' => $faker->boolean,
        'start_time' => 'PT' .str_pad($faker->numberBetween(0,23), 2, '0', STR_PAD_LEFT)
          .'H' .str_pad($faker->numberBetween(0,59), 2, '0', STR_PAD_LEFT)
          .'M',
        'end_time' => 'PT' .str_pad($faker->numberBetween(0,23), 2, '0', STR_PAD_LEFT)
          .'H' .str_pad($faker->numberBetween(0,59), 2, '0', STR_PAD_LEFT)
          .'M',
        'forced_date' => null,
        'buy_tickets_link' => $faker->url,
        'list_description' => $faker->paragraph(2),
        'audience' => $faker->randomDigit,
        'migrated_node_id' => $faker->randomNumber(4),
        'migrated_at' => $faker->dateTimeThisYear,
        'migrated_slug' => $faker->slug,
        'alt_types' => '[]',
        'alt_audiences' => '[]',
        'survey_link' => $faker->url,
        'email_series' => $faker->randomElement(['Yes','No']),
        'door_time' => 'PT' .str_pad($faker->numberBetween(0,23), 2, '0', STR_PAD_LEFT)
          .'H' .str_pad($faker->numberBetween(0,59), 2, '0', STR_PAD_LEFT)
          .'M',
        'is_registration_required' => $faker->boolean,
        'meta_title' => $faker->sentence(3),
        'meta_description' => $faker->paragraph(3),
        'event_type' => $faker->randomDigit,
    ];
});
