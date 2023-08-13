<?php

namespace App\Listeners;

use App\Http\Traits\ConvertTimeZone;
use App\Models\LoginHistory;
use App\Models\Reminder;
use DateTime;
use DateTimeZone;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginSuccessful
{

    use ConvertTimeZone;
    private $clientOriginalTime,$_convertedTime;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(Login $event)
    {
        auth()->user()->update([
            'timezone' => request()->timezone
        ]);
        //check if user exist on reminder table
        $checkUsers = Reminder::where('user_id',auth()->user()->id)->get();
        if(!$checkUsers->isEmpty()){
             //check current login user timezone if its not same on the database
            foreach ($checkUsers as $user) {
                if($user->timezone !== request()->timezone){
                    auth()->user()->reminders()->update(
                        [
                            'time' => $this->convertTimeZone(request()->timezone, $user->original_time),
                            'timezone' => request()->timezone
                        ]
                    );
                }
            }
        }else{
            $this->clientOriginalTime = '09:00:00';
            auth()->user()->reminders()->create(
                [
                    'original_time' => $this->clientOriginalTime,
                    'time' => $this->convertTimeZone(request()->timezone, $this->clientOriginalTime),
                    'timezone' => request()->timezone
                ]
            );
        }
        LoginHistory::create([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->server('HTTP_USER_AGENT'),
        ]);
    }
}
