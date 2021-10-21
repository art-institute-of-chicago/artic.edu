<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published' => $this->faker->boolean,
            'position' => $this->faker->randomDigit,
            'title' => $this->faker->sentence(3),
            'type' => $this->faker->randomDigit,
        ];
    }
}
