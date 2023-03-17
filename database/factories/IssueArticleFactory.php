<?php

namespace Database\Factories;

use App\Models\IssueArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

class IssueArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IssueArticle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published' => true,
        ];
    }
}
