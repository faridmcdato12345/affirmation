<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Services\CacheAffirmationService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return (new CacheAffirmationService())
                ->getData()
                ->where('category_id',Auth::user()->active_category_id)
                ->random(1)
                ->first();
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
