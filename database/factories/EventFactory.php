<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published' => true,
            'publish_start_date' => Carbon::parse('-1 week'),
            'title' => $this->faker->sentence(3),
            'landing' => $this->faker->boolean,
            'is_private' => false,
            'is_ticketed' => $this->faker->boolean,
            'is_free' => $this->faker->boolean,
            'layout_type' => 0,
            'is_member_exclusive' => $this->faker->boolean,
            'is_sold_out' => $this->faker->boolean,
            'is_registration_required' => $this->faker->boolean,
            'is_after_hours' => $this->faker->boolean,
            'is_admission_required' => $this->faker->boolean,
            'add_to_event_email_series' => $this->faker->boolean,
            'is_rsvp' => $this->faker->boolean,
            'is_sales_button_hidden' => $this->faker->boolean,
        ];
    }
}
