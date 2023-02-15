<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'blurb',
    ];

    public function affirmations()
    {
        return $this->hasMany(Affirmation::class);
    }

    /**
     * Returns a random affirmation child.
     * 
     * @param null
     * @return \App\Models\Affirmation
     */
    public function getRandomAffirmation()
    {
        return $this->affirmations->random(1)->first();
    }

    /**
     * Get all of the users currently using the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
