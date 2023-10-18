<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountabilityPartnerNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'message',
        'user_id',
        'seen_at'
    ];
}
