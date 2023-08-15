<?php

namespace App\Listeners;

use App\Http\Traits\ConvertTimeZone;
use App\Models\Reminder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterSuccessful
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
     * @param  \IlluminateAuthEventsRegistered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        
        $this->clientOriginalTime = '09:00:00';
        auth()->user()->reminders()->create(
            [
                'original_time' => $this->clientOriginalTime,
                'time' => $this->convertTimeZone(request()->timezone, $this->clientOriginalTime),
                'timezone' => request()->timezone
            ]
        );
    }
}
