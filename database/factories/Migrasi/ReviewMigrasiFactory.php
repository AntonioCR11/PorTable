<?php

namespace Database\Factories\Migrasi;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Migrasi\ReviewMigrasi>
 */
class ReviewMigrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>$this->faker->numberBetween(4,9),
            'restaurant_id'=>$this->faker->numberBetween(1,3),
            'rating'=>$this->faker->numberBetween(3,5),
            'message'=>$this->faker->sentence(),

            'created_at'=>$this->faker->dateTimeBetween("-1 years","now"),
            'updated_at'=>$this->faker->dateTimeBetween("-2 months","now"),
        ];
    }
}
