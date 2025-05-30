<?php

namespace Database\Factories;

use App\Models\BuildingClosure;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingClosureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BuildingClosure::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'published' => true,
            'date_start' => today(),
            'date_end' => today(),
            'closure_copy' => 'The museum is closed',
        ];
    }
}
