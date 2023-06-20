<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExerciseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'progress_id'       => 'required|exists:progress,id',
            'happiness_score'   => 'required|integer',
            'belief_score'      => 'required|integer',
            'input1'            => 'required|max:500',
            'input2'            => 'required|max:500',
            'input3'            => 'required|max:500',
        ];
    }
}
