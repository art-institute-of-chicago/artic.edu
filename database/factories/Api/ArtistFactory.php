<?php

namespace Database\Factories\Api;

use App\Models\Api\Artist;
use Aic\Hub\Foundation\Library\Database\ApiFactory;

class ArtistFactory extends ApiFactory
{
    public $model = Artist::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(nbDigits: 5),
            'title' => $this->faker->name(),
            'birth_date' => $this->faker->date(),
            'death_date' => $this->faker->date(),
            'birth_place' => $this->faker->city(),
            'nationality' => $this->faker->country(),
            'description' => '<p>' . $this->faker->sentence() . '</p>',
            'ulan_id' => null,
            'agent_type_title' => 'Individual',
            'agent_type_id' => 7,
        ];
    }
}
