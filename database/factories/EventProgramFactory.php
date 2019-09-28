<?php

use Faker\Generator as Faker;

$factory->define(App\Models\EventProgram::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'is_affiliate_group' => $faker->boolean,
        'is_event_host' => $faker->boolean,
    ];
});
