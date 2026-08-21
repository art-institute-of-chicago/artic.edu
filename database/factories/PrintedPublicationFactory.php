<?php

namespace Database\Factories;

use App\Models\PrintedPublication;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrintedPublicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrintedPublication::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => true,
            'public' => true,
            'title' => ucfirst($this->faker->words(5, asText: true)),
            'short_description' => '<p>' . $this->faker->sentence() . '</p>',
            'listing_description' => '<p>' . $this->faker->sentence() . '</p>',
            'publication_date' => $this->faker->date(),
            'isbn' => $this->faker->isbn13(),
            'number_of_pages' => $this->faker->numberBetween(100, 600),
        ];
    }
}
