<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //variable name => fake() -> Source(data)
            'f_name' => fake()->firstName(),
            'l_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'age' => fake()->numberBetween($min = 16, $max = 25), //random numbers between generator
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
