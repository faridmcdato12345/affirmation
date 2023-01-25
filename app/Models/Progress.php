<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Progress extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'affirmation_id',
    ];

    /**
     * Get the user that owns the progress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the progress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affirmation(): BelongsTo
    {
        return $this->belongsTo(Affirmation::class);
    }

    /**
     * Get the category that owns the progress
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ExerciseResult(): HasMany
    {
        return $this->hasMany(ExerciseResult::class);
    }
}
