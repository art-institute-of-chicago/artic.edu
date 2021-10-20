<?php

namespace Database\Factories;

use App\Models\Hour;
use Illuminate\Database\Eloquent\Factories\Factory;

class HourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published' => true,
            'type' => 0,
        ];
    }
}
