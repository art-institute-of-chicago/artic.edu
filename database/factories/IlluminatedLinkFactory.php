<?php

namespace Database\Factories;

use App\Models\IlluminatedLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class IlluminatedLinkFactory extends Factory
{
    protected $model = IlluminatedLink::class;

    public function definition(): array
    {
        return [
            'title' => fake()->text(maxNbChars: 200),
            'url' => fake()->url(),
            'description' => fake()->paragraph(),
            'published' => true,
        ];
    }
}
