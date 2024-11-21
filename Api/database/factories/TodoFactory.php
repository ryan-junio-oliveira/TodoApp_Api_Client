<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'category' => $this->faker->word,
            'completed' => $this->faker->boolean,
            'reminder' => $this->faker->optional()->dateTime,
            'due_date' => $this->faker->optional()->dateTime,
        ];
    }
}
