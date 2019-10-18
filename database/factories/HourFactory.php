<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Hour::class, function (Faker $faker) {
    return [
        'published' => true,
        'type' => 0,
    ];
});
