<?php

namespace App\Http\Controllers\Auth;

use Str;
use Cookie;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\BrevoSubscription;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Category;
use App\Http\Traits\ConvertTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use ConvertTimeZone;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo        = RouteServiceProvider::HOME;
    protected $redirectToBilling = RouteServiceProvider::BILLING;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'check.referral']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function store(RegisterRequest $request)
    {
        $referred_by = Cookie::get('referral');
     
        $user = User::create($request->validated() + [
            'active_category'      => 1,
            'active_category_type' => Category::class,
            'active_category_id'   => 1,
            'affiliate_id'         => Str::uuid(), 
            'referred_by'          => ($referred_by === null) ? null :  User::where('affiliate_id', $referred_by)->first()->id,
            'timezone'             => $request?->timezone
        ]);

        if ($user->save()) {
            Cookie::queue(Cookie::forget('referral'));
            $clientOriginalTime = '09:00:00';
            $user->reminders()->create(
                [
                    'original_time' => $clientOriginalTime,
                    'time' => $this->convertTimeZone($request->timezone, $clientOriginalTime),
                    'timezone' => $request->timezone
                ]
            );
        }

        //Check subIds subscription
        $subIds = [];
        if($request->app_notifications_subscription) {
            $subIds[] = 5;
        }
        if($request->newsletter_subscription) {
            $subIds[] = 6;
        }

        //Subscribe to Brevo List
        $brevo = new BrevoSubscription();
        $brevo->subscribe($request->email, $request->name, $subIds);

        event(new Registered($user));
        Auth::login($user, $remember = true);

        if($request->redirectTo === '/billing') {
            return redirect(RouteServiceProvider::BILLING);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
