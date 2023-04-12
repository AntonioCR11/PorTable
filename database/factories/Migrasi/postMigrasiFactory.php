<?php

namespace Database\Factories\Migrasi;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Migrasi\postMigrasi>
 */
class postMigrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(4),
            'caption'=>$this->faker->sentence(10),
            'user_id'=>$this->faker->numberBetween(4,9),
            'status'=>$this->faker->numberBetween(0,1),
            'created_at'=>now(),
            'updated_at'=>now()
        ];
    }
}
