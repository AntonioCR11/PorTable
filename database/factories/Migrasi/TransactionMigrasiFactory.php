<?php

namespace Database\Factories\Migrasi;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Migrasi\TransactionMigrasi>
 */
class TransactionMigrasiFactory extends Factory
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
            'reservation_id'=>$this->faker->unique()->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
            'payment_amount'=>$this->faker->randomFloat(2,10000,60000),
            'payment_date_at'=>$this->faker->dateTimeBetween("-1 years","now"),
            'created_at'=>now(),
            'updated_at'=>now()
        ];
    }
}
