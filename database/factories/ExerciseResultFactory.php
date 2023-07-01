<?php

namespace Database\Factories;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExerciseResult>
 */
class ExerciseResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'progress_id' => fake()->numberBetween($min = 1, $max = 11),
            'input1' => fake()->word,
            'input2' => fake()->word,
            'input3' => fake()->word,
            'happiness_score' => fake()->numberBetween($min = 1, $max = 5),
            'belief_score' => fake()->numberBetween($min = 1, $max = 5),
            'created_at' => fake()->date()
        ];
    }
}
