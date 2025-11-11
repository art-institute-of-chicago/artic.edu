<?php

namespace Database\Factories;

use App\Models\DigitalExplorer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Models\DigitalExplorer
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class DigitalExplorerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = DigitalExplorer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
