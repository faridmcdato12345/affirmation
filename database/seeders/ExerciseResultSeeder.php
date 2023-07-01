<?php

namespace Database\Seeders;

use App\Models\ExerciseResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExerciseResult::factory()
        ->count(10)
        ->create();
    }
}
