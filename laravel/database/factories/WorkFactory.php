<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    public function definition(): array
    {
        $types = ['movie', 'series', 'game', 'book'];
        $type = $this->faker->randomElement($types);

        $genres = [
            'movie' => ['Фантастика', 'Драма', 'Боевик', 'Триллер'],
            'series' => ['Детектив', 'Комедия', 'Фэнтези', 'Боевик'],
            'game' => ['RPG', 'Шутер', 'Стратегия', 'Хоррор'],
            'book' => ['Роман', 'Детектив', 'Биография', 'Научпоп'],
        ];

        return [
            'title' => $this->faker->sentence(rand(2, 4)),
            'type' => $type,
            'genre' => $this->faker->randomElement($genres[$type]),
            'release_year' => $this->faker->numberBetween(1995, 2026),
            'author' => $this->faker->name,
            'description' => $this->faker->paragraph(rand(3, 5)),
            'poster_url' => 'https://pic/' . $this->faker->uuid . '/400/600',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}