<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PushNotifSubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $subscription = PushSubscription::where('user_id', auth()->user()->id)->first();
        if(! $subscription) {
            PushSubscription::create([
                'data' => $request->data,
                'user_id' => $request->user_id,
                'notifiable' => $request->notifiable
            ]);
        }
    }
}
