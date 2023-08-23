<?php

namespace Database\Factories;

use A17\Twill\Models\Media;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'author_display' => $this->faker->name(),
            'citation' => null,
            'citations' => '<p>*' . $this->faker->sentence() . '</p>',
            'content' => null,
            'date' => now(),
            'heading' => '<p>' . $this->faker->sentence() . '</p>',
            'hero_caption' => '<p>' . $this->faker->sentence() . '</p>',
            'is_in_magazine' => $this->faker->boolean(),
            'is_unlisted' => $this->faker->boolean(),
            'layout_type' => (int) $this->faker->boolean(),
            'list_description' => '<p>' . $this->faker->sentence() . '</p>',
            'meta_description' => null,
            'meta_title' => null,
            'migrated_at' => null,
            'migrated_node_id' => null,
            'publish_end_date' => null,
            'publish_start_date' => null,
            'published' => $this->faker->boolean(),
            'subtype' => ucfirst($this->faker->word()),
            'title' => ucfirst($this->faker->words(5, true)),
            'title_display' => '<i>' . ucfirst($this->faker->words(5, true)) . '</i>',
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Article $article) {
            $article->medias()->attach(
                Media::create(['uuid' => $this->faker->uuid(), 'width' => 1, 'height' => 1 ]),
                ['crop' => 'default', 'role' => 'hero'],
            );
        });
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published' => true,
            ];
        });
    }

    public function visible(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'publish_end_date' => now()->addDay(),
                'publish_start_date' => now()->subDay(),
            ];
        });
    }

    public function notUnlisted(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_unlisted' => false,
            ];
        });
    }
}
