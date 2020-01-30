<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\Issue::class, function (Faker $faker) {
    return [
        'published' => true,
    ];
});
