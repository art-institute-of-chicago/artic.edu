<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'published' => true,
            'is_listed' => true,
            'is_short' => false,
            'youtube_id' => $this->faker->regexify('[a-zA-Z0-9_-]{11}'),
            'privacy' => 'public',
        ];
    }

    public function withYoutubeId(string $youtubeId): self
    {
        return $this->state(fn (array $attributes) => [
            'youtube_id' => $youtubeId,
        ]);
    }

    public function unpublished(): self
    {
        return $this->state(fn (array $attributes) => [
            'published' => false,
        ]);
    }
}
