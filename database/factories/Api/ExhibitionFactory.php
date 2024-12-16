<?php

namespace Database\Factories\Api;

use App\Models\Api\Exhibition;
use Aic\Hub\Foundation\Library\Database\ApiFactory;

class ExhibitionFactory extends ApiFactory
{
    public $model = Exhibition::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(nbDigits: 5),
            'title' => ucfirst($this->faker->words(nb: 5, asText: true)),
        ];
    }
}
