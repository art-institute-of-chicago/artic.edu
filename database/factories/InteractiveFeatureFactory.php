<?php

namespace Database\Factories;

use App\Models\InteractiveFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

class InteractiveFeatureFactory extends Factory
{
    protected $model = InteractiveFeature::class;

    public function definition(): array
    {
        return [
            'archived' => false,
            'published' => true,
            'title' => ucfirst(fake()->words(3, asText: true)),
        ];
    }
}
