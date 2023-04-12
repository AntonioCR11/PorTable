<?php

namespace Database\Factories\Migrasi;

use App\Models\Migrasi\userMigrasi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Migrasi\RestaurantMigrasi>
 */
class RestaurantMigrasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstname = $this->faker->firstName();
        $lastname = $this->faker->lastName();
        $random_start = $this->faker->numberBetween(9,10);
        return [
            'full_name'=>"$firstname $lastname",
            'address'=>$this->faker->address(),
            'phone'=>$this->faker->phoneNumber(),
            'user_id'=>$this->faker->unique()->numberBetween(1,3),
            'col'=>$this->faker->randomNumber(1,10),
            'row'=>$this->faker->randomNumber(1,10),
            'start_time (am)'=>"$random_start",
            'description'=>$this->faker->sentence(20),

            'created_at'=>now(),
            'updated_at'=>now()
        ];
    }
}
