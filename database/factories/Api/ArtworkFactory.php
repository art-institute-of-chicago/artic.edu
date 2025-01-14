<?php

namespace Database\Factories\Api;

use App\Models\Api\Artwork;
use Aic\Hub\Foundation\Library\Database\ApiFactory;

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
}
