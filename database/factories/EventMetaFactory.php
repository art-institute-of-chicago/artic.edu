<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\EventMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventMeta::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => Carbon::parse('+1 week'),
            'date_end' => Carbon::parse('+2 weeks'),
        ];
    }
}
