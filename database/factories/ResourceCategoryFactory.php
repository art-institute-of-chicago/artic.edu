<?php

namespace Database\Factories;

use App\Models\ResourceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceCategoryFactory extends Factory
{
    protected $model = ResourceCategory::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->words(2, true)),
            'type' => $this->faker->randomElement(['content', 'audience', 'topic']),
        ];
    }
}
