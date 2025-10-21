<?php

namespace Database\Factories;

use App\Models\Caption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Models\Caption
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class CaptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Caption::class;

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
