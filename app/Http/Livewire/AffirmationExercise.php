<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ExerciseResults;

class AffirmationExercise extends Component
{
    /**
     * THIS IS NO LONGER IN USE. SAVED FOR FUTURE REFERENCE.
     */
    public $exerciseResults;
    public $progress_id;

    // TODO: Fix this to validate progress_id is owned by User making the call.
    protected $rules = [
        'exerciseResults.progress_id' => 'required',
        'exerciseResults.believe' => 'boolean',
        'exerciseResults.input1' => 'string|max:500',
        'exerciseResults.input2' => 'string|max:500',
        'exerciseResults.input3' => 'string|max:500',
    ];

    public function mount($progress_id) {
        $this->progress_id = $progress_id;
    }

    public function render()
    {
        return view('livewire.affirmation-exercise');
    }

    public function save()
    {
        $this->validate();
        // dd($this->exerciseResults);
        $this->exerciseResults->save();
    }
}
