<?php

namespace Database\Factories;

use App\Models\LandingPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandingPageFactory extends Factory
{
    protected $model = LandingPage::class;

    public function definition(): array
    {
        return [
            'type_id' => $this->faker->randomElement(array_keys(LandingPage::TYPES)),
            'title' => $this->faker->words(3, true),
            'published' => true,
        ];
    }
}
