<?php

namespace Database\Factories\Api;

use App\Models\Api\Artwork;
use App\Models\Api\Image;

class ArtworkFactory extends ApiFactory
{
    public $model = Artwork::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(nbDigits: 5),
            'title' => ucfirst($this->faker->words(nb: 5, asText: true)),
            'edition' => "{$this->faker->randomNumber()} of {$this->faker->randomNumber(nbDigits: 2, strict: true)}",
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Artwork $artwork) {
            $artwork->mainImage()->attach(
                Image::create(['uuid' => $this->faker->uuid()]),
                ['crop' => 'default', 'role' => 'hero'],
            );
        });
    }
}
