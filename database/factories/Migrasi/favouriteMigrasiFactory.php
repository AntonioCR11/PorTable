<?php

namespace Database\Factories\Migrasi;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class favouriteMigrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'restaurant_id'=>$this->faker->numberBetween(1,3),
            'user_id'=>$this->faker->unique()->numberBetween(4,9),
        ];
    }
}
