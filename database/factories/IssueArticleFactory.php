<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Models\IssueArticle::class, function (Faker $faker) {
    return [
        'published' => true,
    ];
});
