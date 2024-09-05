<?php

namespace Database\Factories;

use App\Enums\DigitalPublicationArticleType;
use App\Models\DigitalPublicationArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

class DigitalPublicationArticleFactory extends Factory
{
    protected $model = DigitalPublicationArticle::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(5, true),
            'article_type' => $this->faker->randomElement(array_map(
                fn ($type) => $type->value,
                DigitalPublicationArticleType::cases()
            )),
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
