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
        //fetch all affirmation that`s not in the progress table
        $filteredProgress = Category::with(['affirmations' => function($q){
            $q->whereDoesntHave('progress');
          }])->find(Auth::user()->active_category_id);
        // count affirmation that is not in the progress table
        if(count(collect($filteredProgress->affirmations)) == 0 || collect($filteredProgress->affirmations)->isEmpty()){
            
            //fetch all affirmation thats in the progress table that is not processed
            $query = Category::with(['affirmations' => function($q){
                $q->whereHas('progress', function(Builder $builder){
                    $builder->where('status','=','0')->where('user_id',auth()->user()->id);
                });
              }])->find(Auth::user()->active_category_id);
            return count(collect($query->affirmations)) ? [
                'affirm' => collect($query->affirmations)->random(1)->first(),
                'new' => false
            ] : null;
        }
        return [
            'affirm' => collect($filteredProgress->affirmations)->random(1)->first(),
            'new' => true
        ];
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
