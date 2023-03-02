<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Models\ExerciseResult;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ExerciseResultController extends Controller
{
    public function rules() {
            return [
                'user_id' => 'required',
                'progress_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        if (User::find($request->user_id)->progress()->find($value) === null) {
                            $fail('The '.$attribute.' is invalid.');
                        }
                    },
            ],
                'happiness_score' => 'integer',
                'belief_score' => 'integer',
                'input1' => 'string|max:500',
                'input2' => 'string|max:500',
                'input3' => 'string|max:500',
        ];
    }

    public function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(response()->json([
        'success'   => false,
        'message'   => 'Validation errors',
        'data'      => $validator->errors()
    ]));
    }

    public function store(Request $request) 
    {
        $input = $request->all();
        if(User::find($input['user_id'])->progress()->find($input['progress_id']) !== null) {
            $exerciseResult = ExerciseResult::create($input);
            return response()->json(['success' => true, 'message' => 'exercise results saved.']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to match user and progress.']);
    }
}
