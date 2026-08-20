<?php

namespace Database\Factories;

use App\Models\Highlight;
use Illuminate\Database\Eloquent\Factories\Factory;

class HighlightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Highlight::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => true,
            'title' => ucfirst($this->faker->words(5, asText: true)),
            'short_copy' => '<p>' . $this->faker->sentence() . '</p>',
            'highlight_type' => Highlight::NORMAL,
            'is_unlisted' => false,
            'is_in_magazine' => false,
        ];
    }
}
