<?php

namespace Database\Factories;

use App\Models\GenericPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenericPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GenericPage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => $this->faker->boolean,
            'position' => $this->faker->randomDigit,
            'title' => $this->faker->sentence(3),
            'short_description' => $this->faker->paragraph(),
            'listing_description' => $this->faker->paragraph(),
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published' => 'true',
                'publish_start_date' => now(),
            ];
        });
    }
}
