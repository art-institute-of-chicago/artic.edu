<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Page::class, function (Faker $faker) {
    return [
        'published' => $faker->boolean,
        'position' => $faker->randomDigit,
        'title' => $faker->sentence(3),
        'type' => $faker->randomDigit,
    ];
});
