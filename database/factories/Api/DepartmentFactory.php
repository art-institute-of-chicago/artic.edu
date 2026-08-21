<?php

namespace Database\Factories\Api;

use App\Models\Api\Department;
use Aic\Hub\Foundation\Library\Database\ApiFactory;

class DepartmentFactory extends ApiFactory
{
    public $model = Department::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(nbDigits: 5),
            'title' => ucfirst($this->faker->words(nb: 5, asText: true)),
            'description' => '<p>' . $this->faker->sentence() . '</p>',
        ];
    }
}
