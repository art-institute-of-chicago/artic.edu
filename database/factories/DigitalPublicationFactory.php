<?php

namespace Database\Factories;

use App\Models\DigitalPublication;
use Illuminate\Database\Eloquent\Factories\Factory;

class DigitalPublicationFactory extends Factory
{
    protected $model = DigitalPublication::class;

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
