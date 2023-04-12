<?php

namespace Database\Factories\Migrasi;

use App\Models\Migrasi\restaurantMigrasi;
use App\Models\Migrasi\userMigrasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Migrasi\TableMigrasi>
 */
class TableMigrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'restaurant_id'=>$this->faker->numberBetween(1,10),
            'seats'=>$this->faker->numberBetween(1,20),
            'status'=>$this->faker->randomElement(['0','1'])
        ];
    }
}
