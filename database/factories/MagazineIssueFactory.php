<?php

namespace Database\Factories;

use App\Models\MagazineIssue;
use Illuminate\Database\Eloquent\Factories\Factory;

class MagazineIssueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MagazineIssue::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => true,
            'title' => ucfirst($this->faker->words(3, asText: true)),
            'list_description' => '<p>' . $this->faker->sentence() . '</p>',
            'publish_start_date' => $this->faker->date(),
        ];
    }
}
