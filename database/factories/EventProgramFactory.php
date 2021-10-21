<?php

namespace Database\Factories;

use App\Models\EventProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventProgramFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventProgram::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'is_affiliate_group' => $this->faker->boolean,
            'is_event_host' => $this->faker->boolean,
        ];
    }
}
