<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем 50 случайных отзывов
        Review::factory()->count(50)->create();
    }
}