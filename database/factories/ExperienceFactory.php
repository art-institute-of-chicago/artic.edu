<?php

namespace Database\Factories;

use App\Models\Experience;
use App\Models\InteractiveFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        return [
            'archived' => false,
            'interactive_feature_id' => InteractiveFeature::factory(),
            'published' => true,
            'title' => ucfirst(fake()->words(3, asText: true)),
        ];
    }
}
