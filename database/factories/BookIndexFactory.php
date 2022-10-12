<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookIndex>
 */
class BookIndexFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'book_id'   => $this->faker->numberBetween(1, 10),
            'index_id' => $this->faker->numberBetween(1, 10),
            'title' => $this->faker->name(),
            'page'  => $this->faker->numberBetween(1, 15),
        ];
    }
}
