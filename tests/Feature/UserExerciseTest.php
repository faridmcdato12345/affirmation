<?php

namespace Tests\Feature;

use App\Models\Affirmation;
use App\Models\Progress;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserExerciseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_storing_the_exercise_result_and_updating_the_progress_table_status_column()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        Progress::create([
            'user_id'            => $user->id,
            'affirmation_id'     => Affirmation::all()->random()->id,
            'affirmation_type'   => 'App\Models\Category'
        ]);
        $response = $this->actingAs($user)
                        ->post('/api/exercise',[
                            'progress_id' => Progress::all()->random()->id,
                            'input1' => fake()->sentence(),
                            'input2' => fake()->sentence(),
                            'input3' => fake()->sentence(),
                            'happiness_score' => fake()->numberBetween(1,5),
                            'belief_score' => fake()->numberBetween(1,5)
                        ]);
        $response->assertRedirect('/exercise');
        //$response->assertStatus(201);
    }
}
