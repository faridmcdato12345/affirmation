<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategories extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function affirmations()
    {
        return $this->hasMany(UserAffirmation::class);
    }
    public function getRandomAffirmation()
    {
        return $this->affirmations->random(1)->first();
    }
}
