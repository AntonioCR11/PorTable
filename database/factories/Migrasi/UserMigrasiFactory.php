<?php

namespace Database\Factories\Migrasi;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Migrasi\UserMigrasi>
 */
class UserMigrasiFactory extends Factory
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
        return [
            'username'=>$this->faker->sentence(1,true),
            'password'=>Hash::make('123'),
            'full_name'=>"$firstname $lastname",
            'date_of_birth'=>$this->faker->dateTimeBetween("-30 years","now"),
            'address'=>$this->faker->address(),
            'email'=>Str::lower($firstname)."@gmail.com",
            'phone'=>$this->faker->phoneNumber(),
            'gender'=>$this->faker->numberBetween(1,2),
            'balance'=>$this->faker->numberBetween(1000,100000),
            'blocked'=>$this->faker->numberBetween(0,0),
            'created_at'=>now(),
            'updated_at'=>now()
        ];
    }
}
