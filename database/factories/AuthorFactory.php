<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => true,
            'title' => $this->faker->name(),
            'description' => '<p>' . $this->faker->sentence() . '</p>',
            'list_description' => '<p>' . $this->faker->sentence() . '</p>',
        ];
    }
}
