<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spark\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active_category',
        'affiliate_id',
        'referred_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
         'trial_ends_at' => 'datetime',
    ];

    /**
     * Get the current category the User is on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function activeCategory(): BelongsTo {
        return $this->belongsTo(Category::class, 'active_category');
    }

    /**
     * Get all of the progress for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    /**
     * Get an Affirmation that was stored in progress on the same day or get a new Affirmation.
     *
     * @return Affirmation
     */
    public function getAffirmation(): Affirmation
    {
        $todaysAffirmation = null;

        $progress = $this->progress->where('created_at', '>', today());
        
        if ($progress->count() > 0) {
            // return today's previously generated affirmation
            $todaysAffirmation = $progress->first()->affirmation;
        } else {
            // generate and store a new daily affirmation
            $todaysAffirmation = $this->activeCategory->getRandomAffirmation();

            $p = Progress::create([
                'user_id' => $this->id,
                'affirmation_id' => $todaysAffirmation->id,
            ]);
        }
        return $todaysAffirmation;
    }

    /**
     * Get a referral link for the User.
     *
     * @return String
     */
    public function getReferralLink(): String
    {
        return env('APP_URL') . 'register?ref=' . $this->affiliate_id;
    }

    /**
     * Determine if user is subscribed to one of the premium subscriptions
     * as ->subscribed() does not seem to work as intended.
     * 
     * @return Bool
     */
    public function subscribedToPremium(): Bool
    {
        $plans = config('spark.billables.user.plans');
        foreach($plans as $plan) {
            if ($this->subscribedToPrice($planId = $plan['monthly_id']) || $this->subscribedToPrice($planId = $plan['yearly_id'])) {
                return true;
            }
        }
        return false;
    }
}
