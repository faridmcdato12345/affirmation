<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountabilityPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'accepted_at',
        'declined_at',
        'inviter_id'
    ];

    public function requestedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requestingUser()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function scopePersonalInvite(Builder $query): void
    {
        $query->where('inviter_id', auth()->id());
    }

    public function scopePartnerRequest(Builder $query): void
    {
        $query->where('user_id', auth()->id());
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone(auth()->user()->timezone ?? config('app.timezone'))->format('F j, Y h:i A');
    }
}
