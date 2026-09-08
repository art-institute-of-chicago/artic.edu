<?php

namespace Database\Factories;

use App\Models\AdCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends Factory<AdCampaign>
 */
class AdCampaignFactory extends Factory
{
    protected $model = AdCampaign::class;

    public function definition(): array
    {
        return [
            'published' => $this->faker->boolean(),
            'position' => $this->faker->randomNumber(),
            'title' => $this->faker->text(),
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
            'header' => $this->faker->text(),
            'description' => $this->faker->text(),
            'destination_url' => $this->faker->url(),
            'destination_label' => $this->faker->text(),
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published' => true,
            ];
        });
    }

    public function ordered(): Factory
    {
        return $this->sequence(function (Sequence $sequence) {
            return [
                'position' => $sequence->index + 1,
            ];
        });
    }
}
