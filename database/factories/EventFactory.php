<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Event::class, function (Faker $faker) {
    return [
        'published' => true,
        'publish_start_date' => Carbon::parse('-1 week'),
        'title' => $faker->sentence(3),
        'landing' => $faker->boolean,
        'is_private' => false,
        'is_ticketed' => $faker->boolean,
        'is_free' => $faker->boolean,
        'layout_type' => 0,
        'is_member_exclusive' => $faker->boolean,
        'is_sold_out' => $faker->boolean,
        'is_registration_required' => $faker->boolean,
        'is_after_hours' => $faker->boolean,
        'is_admission_required' => $faker->boolean,
        'add_to_event_email_series' => $faker->boolean,
        'is_rsvp' => $faker->boolean,
        'is_sales_button_hidden' => $faker->boolean,
    ];
});

$factory->define(App\Models\EventMeta::class, function (Faker $faker) {
    return [
        'date' => Carbon::parse('+1 week'),
        'date_end' => Carbon::parse('+2 weeks'),
    ];
});
