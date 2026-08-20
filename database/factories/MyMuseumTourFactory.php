<?php

namespace Database\Factories;

use App\Models\MyMuseumTour;
use Illuminate\Database\Eloquent\Factories\Factory;

class MyMuseumTourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MyMuseumTour::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'creator_email' => $this->faker->safeEmail(),
            'marketing_opt_in' => false,
            'confirmation_sent' => false,
            'tour_json' => [
                'title' => ucfirst($this->faker->words(3, asText: true)),
                'description' => $this->faker->sentence(),
                'artworks' => [],
            ],
            'timestamp' => now(),
        ];
    }
}
