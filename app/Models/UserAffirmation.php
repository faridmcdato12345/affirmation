<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAffirmation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('F j, Y h:i A');
    }
}
