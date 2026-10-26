<?php

namespace Database\Factories\Api;

use App\Models\Api\Gallery;
use Aic\Hub\Foundation\Library\Database\ApiFactory;

class GalleryFactory extends ApiFactory
{
    public $model = Gallery::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(nbDigits: 5),
            'title' => ucfirst($this->faker->words(nb: 5, asText: true)),
            'description' => '<p>' . $this->faker->sentence() . '</p>',
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
