<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','data','notifiable'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
