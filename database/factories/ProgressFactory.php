<?php

namespace Database\Factories;

use App\Models\Progress;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Progress>
 */
class ProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = Progress::latest('id')->first();
        $dd = $date->created_at;
        return [
            'user_id' => 3,
            'affirmation_type' => 'App\Models\Affirmation',
            'affirmation_id' => fake()->unique()->numberBetween(1,34),
            'status' => '1',
            'created_at' => $dd->subDay()
        ];
    }
}
