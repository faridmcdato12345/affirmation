<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'time',
        'custom_message',
        'timezone',
        'status',
        'original_time',
        'reminder_type',
        'dispatched'
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
