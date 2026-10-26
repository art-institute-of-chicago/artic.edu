<?php

namespace Database\Factories;

use App\Models\EducatorResource;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducatorResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EducatorResource::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => true,
            'public' => true,
            'publish_start_date' => $this->faker->date(),
            'title' => ucfirst($this->faker->words(4, asText: true)),
            'title_display' => ucfirst($this->faker->words(4, asText: true)),
            'listing_description' => '<p>' . $this->faker->sentence() . '</p>',
            'short_description' => '<p>' . $this->faker->sentence() . '</p>',
        ];
    }
}
