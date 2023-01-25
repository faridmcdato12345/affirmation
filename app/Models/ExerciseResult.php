<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseResult extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exercise_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'progress_id',
        'believe',
        'input1',
        'input2',
        'input3',
    ];

    /**
     * Get the daily progress attached to this exercise.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function progress(): BelongsTo
    {
        return $this->belongsTo(Progress::class);
    }
}
