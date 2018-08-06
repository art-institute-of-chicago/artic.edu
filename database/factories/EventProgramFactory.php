<?php

use Faker\Generator as Faker;

$factory->define(App\Models\EventProgram::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
        'name' => $faker->sentence(3),
    ];
});
