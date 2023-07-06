<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Spark\Billable;
use Nette\Utils\Arrays;
use App\Models\Setting\Feedback;
use App\Models\Setting\ReportBug;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'active_category_id',
        'active_category_type',
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
        'trial_ends_at'     => 'datetime',
    ];

    /**
     * Get the current category the User is on.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activeCategory(): MorphTo
    {
        return $this->morphTo();
        // return $this->belongsTo(Category::class, 'active_category');
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

    public function bug(): HasMany
    {
        return $this->hasMany(ReportBug::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function getAffirmation()
    {
        $todaysAffirmation = null;

        $progress = $this->progress->where('created_at', '>', today())->first();

        if ($progress) {
            // return today's previously generated affirmation
            $todaysAffirmation = $progress->affirmation;
        } else {
            // generate and store a new daily affirmation
            $todaysAffirmation = $this->activeCategory->getRandomAffirmation();

            Progress::create([
                'user_id'            => $this->id,
                'affirmation_id'     => $todaysAffirmation->id,
                'affirmation_type'   => $this->active_category_type == 'App\Models\Category' ? Affirmation::class : UserAffirmation::class
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
    /**
     * get the exercise result of the user
     */
    public function getUserExercise()
    {
        $user = ExerciseResult::with('progress.affirmation')->whereHas('progress',function($query){
            $query->where('user_id',Auth::user()->id);
        });
        return $user;
    }

    public function getUserCalendar()
    {
        $exercises = $this->getUserExercise()->orderBy('created_at','asc')->get();
        $d = $this->generateArrayNumbers(count($exercises) - 1);
        $dataArray = [];

        foreach ($exercises as $key => $exercise) {
            if(!Auth::user()->subscribedToPremium()){
                if(in_array($key,$d)){
                    array_push($dataArray,[
                        'id'=> $exercise->id,
                        'title' => $exercise->progress->affirmation->text,
                        'start' => $exercise->created_at->format('Y-m-d'),
                        'backgroundColor' => '#8ABE53',
                        'borderColor' => '#8ABE53'
                    ]);
                } else {
                    array_push($dataArray,[
                        'id'=> $exercise->id,
                        'title' => 'Subcribe to premium to see',
                        'start' => $exercise->created_at->format('Y-m-d'),
                        'backgroundColor' => 'red',
                        'borderColor' => 'red'
                    ]);
                }
            } else {
                array_push($dataArray,[
                    'id'=> $exercise->id,
                    'title' => $exercise->progress->affirmation->text,
                    'start' => $exercise->created_at->format('Y-m-d'),
                    'backgroundColor' => '#8ABE53',
                    'borderColor' => '#8ABE53'
                ]);
            }

        }
        return $dataArray;
    }

    public function getUserChart()
    {
        if(Auth::user()->subscribedToPremium()){
            $exercises = $this->getUserExercise()->orderBy('created_at','asc')->get();
        }else{
            $exercises = $this->getUserExercise()->orderBy('created_at','asc')->latest()->take(6)->get();
            unset($exercises[0]);
        }
        $labelData = [];
        $happinessDataPoints = [];
        $beliefDataPoints = [];
        foreach ($exercises as $key => $exercise) {
           $labelData[] = $exercise->created_at->format('Y-m-d');
           $happinessDataPoints[] = $exercise->happiness_score;
           $beliefDataPoints[] = $exercise->belief_score;
        }
        return [
            'data' => [
                'label' => $labelData,
                'happiness' => $happinessDataPoints,
                'belief' => $beliefDataPoints,
            ],
            'user_is_paid' => Auth::user()->subscribedToPremium() ? true : false
        ];
    }

    private function generateArrayNumbers($value)
    {
        $numbers = [];
        for($i = 0; $i <= $value; $i++)
        {
            if($i > 4)
            {
                break;
            }
            $numbers[] = intval($value - $i);
        }
        return $numbers;
    }
}
