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
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // protected function originalTime(): Attribute
    // {
        
    //     return Attribute::make(
    //         get: fn ($value) => $this->reformatTime($value)
    //     );
    // }

    // public function reformatTime($time)
    // {
    //     $dateTime = new DateTime($time);
    //     return $dateTime->format("h:i A");
    // }
}
