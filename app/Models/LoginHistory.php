<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone(auth()->user()->timezone ?? config('app.timezone'))->format('F j, Y h:i A');
    } 
}
