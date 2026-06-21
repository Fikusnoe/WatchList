<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'work_id' => Work::inRandomOrder()->first()->id ?? Work::factory(),
            'rating'  => $this->faker->numberBetween(1, 10),
            'text'    => $this->faker->paragraph(2),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}