<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Services\CacheAffirmationService;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

    public function affirmations(): HasMany
    {
        return $this->hasMany(Affirmation::class);
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
    /**
     * Returns a random affirmation child.
     * 
     * @param null
     * @return \App\Models\Affirmation
     */
    public function getRandomAffirmation()
    {
        $filteredProgress = Category::with(['affirmations' => function($q){
            $q->whereDoesntHave('progress');
          }])->find(Auth::user()->active_category_id);
        $affirmationCollection = collect($filteredProgress->affirmations)->random(1)->first();
        // $dd =  (new CacheAffirmationService())
        //         ->getData()
        //         ->where('category_id',Auth::user()->active_category_id)
        //         ->where('id',$affirmationCollection->id)
        //         ->first();
        return $affirmationCollection;
    }
    /**
     * Return the all the progress that belongs to this category
     * 
     */
    public function getProgress($userId,$categoryId)
    {
        return $this->with(['affirmations' => function($q) use ($userId){
            $q->whereHas('progress',function(Builder $query) use ($userId){
              $query->where('status','=','1')->where('user_id',$userId);
            });
          }])
          ->withCount('affirmations')
          ->find($categoryId);
    }
}
