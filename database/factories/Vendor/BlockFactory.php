<?php

namespace Database\Factories\Vendor;

use App\Models\Vendor\Block;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class BlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Block::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'position' => 0,
            'content' => [],
            'type' => collect(config('twill.block_editor.block-order'))->random(),
        ];
    }

    public function withContentHeading(): Factory
    {
        return $this->state(function (array $attributes) {
            $content = $attributes['content'];
            $content['heading'] = fake()->sentence();
            return [
                'content' =>  $content,

            ];
        });
    }

}
