<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\ExerciseResult;
use Illuminate\Support\Facades\Log;

class ExerciseResultController extends Controller
{
    public function store(ExerciseRequest $request) 
    {
        if($request->user()->progress()->find($request->safe()->only(['progress_id']))) {
            ExerciseResult::create($request->validated());
            return back()->with('success', 'Exercise results saved.');
        }

        return response()->json([
            'success' => false, 
            'message' => 'Failed to match user and progress.'
        ]);
    }
}
