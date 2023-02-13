<?php

namespace Database\Factories;

use App\Models\IssueArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueArticleFactory extends Factory
{
    protected $model = IssueArticle::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(5, true),
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
