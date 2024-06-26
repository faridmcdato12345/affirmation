<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Setting\Feedback;
use App\Models\Setting\ReportBug;
use App\Services\CacheAffirmationService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Billable;

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
        'timezone',
        'background_image',
        'fcm_token',
        'isNotify',
        'show_introduction',
        'app_update_trigger',
        'app_notifications_subscription',
        'newsletter_subscription'
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
    
    public function pushSubscriptions()
    {
        return $this->hasMany(PushSubscription::class);
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value)
        );
    }

    public function backgroundImages()
    {
        return $this->hasMany(UserBackground::class);
    }

    public function activeCategory(): MorphTo
    {
        return $this->morphTo();
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

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

    public function affirmationStatus()
    {
        return $this->hasOneThrough(ExerciseResult::class, Progress::class);
    }

    public function accountabilityReminders()
    {
        return $this->hasOne(AccountabilityPartnerNotification::class, 'partner_id')->whereDate('created_at', today())->latest();
    }

    public function getAffirmation()
    {
        $todaysAffirmation = null;
        $progress = $this->progress->where('created_at','>', today())->where('status','=','0')->first();
        
        if ($progress) {
            // return today's previously generated affirmation
            if ($progress->affirmation_type === Affirmation::class) {
                $todaysAffirmation = [
                    'affirm' => (new CacheAffirmationService())
                                ->getAffirmations()
                                ->where('id',$progress->affirmation_id)
                                ->first()
                ];
            }

            if ($progress->affirmation_type === UserAffirmation::class) {
                $todaysAffirmation = [
                    'affirm' => (new CacheAffirmationService())
                                ->getUserAffirmations()
                                ->where('id',$progress->affirmation_id)
                                ->first()
                ];
            }
        } else {
            // generate and store a new daily affirmation
            $todaysAffirmation = $this->activeCategory->getRandomAffirmation();
            if(!is_null($todaysAffirmation)){
                if($todaysAffirmation['new']){
                    Progress::create([
                        'user_id'            => $this->id,
                        'affirmation_id'     => $todaysAffirmation['affirm']->id,
                        'affirmation_type'   => $this->active_category_type == 'App\Models\Category' ? Affirmation::class : UserAffirmation::class,
                    ]);
                }
            }
        }
        return $todaysAffirmation;
    }

    public function getReferralLink(): String
    {
        return env('APP_URL') . 'register?ref=' . $this->affiliate_id;
    }

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

    public function getUserExercise()
    {
        $user = ExerciseResult::with('progress.affirmation')->whereHas('progress',function($query){
            $query->where('user_id',Auth::user()->id);
        });
        return $user;
    }

    public function getUserCalendar()
    {
        $exercises = $this->getUserExercise()->get();
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
                        'borderColor' => '#8ABE53',
                        'happiness' => $exercise->happiness_score,
                        'belief' => $exercise->belief_score,
                        'input_1' => $exercise->input1,
                        'input_2' => $exercise->input2,
                        'input_3' => $exercise->input3,
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
                    'borderColor' => '#8ABE53',
                    'happiness' => $exercise->happiness_score,
                    'belief' => $exercise->belief_score,
                    'input_1' => $exercise->input1,
                    'input_2' => $exercise->input2,
                    'input_3' => $exercise->input3,
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
            //unset($exercises[0]);
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
