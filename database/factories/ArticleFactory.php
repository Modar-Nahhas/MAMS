<?php

namespace Database\Factories;

use App\Enums\ArticleStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'content' => $this->faker->text,
            'user_id' => User::factory(),
            'reviewed_by' => 1,
            'approved_by' => 1,
            'status' => ArticleStatusEnum::Approved->value
        ];
    }
}
