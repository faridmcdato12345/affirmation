<?php

namespace App\Console\Commands;

use App\Models\PushSubscription;
use App\Models\Reminder;
use Illuminate\Console\Command;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_get();
        $serverTimeNow = date("H:i");

        $this->info($serverTimeNow);

        $webPush = new WebPush([
            "VAPID" => [
                "publicKey" => "BPPP43im220nXU30GVoHws2lU_R_nz1IZeyOFSEM1CzqCADXqjGEKS2WArCHtjJ7UHmDZRfrHVrqZFQYLiCT5BI",
                "privateKey" => "oLlTzEdeAT0fAd0Cd46yiKeii-_AETDFJUUGIWH_-c0",
                "subject" => config('app.url')
            ]
        ], ["verify" => false]);
            
        $reminders = Reminder::select('user_id','time','status','custom_message','original_time')
            ->where('time', $serverTimeNow)
            ->where('status',true)
            ->get();

        if(!$reminders->isEmpty()){
            foreach ($reminders as $reminder) {
                $pushes = PushSubscription::where('user_id', $reminder->user_id)->where('notifiable', 1)->get();
                $dd = [
                    'title' => 'Affirmation',
                    'body' => $reminder->custom_message ?? 'Unlock a boost of positivity for your day – open the app now to discover your personalized affirmation and set the tone for a brighter, more empowered you!',
                    'url' => config('app.url')
                ];

                $this->info("json: " . json_encode($dd));

                if(!$pushes->isEmpty()){
                    foreach($pushes as $push){
                        try {
                            $result = $webPush->sendOneNotification(
                                Subscription::create(json_decode($push->data, true)),
                                json_encode($dd)
                            );
                            $this->info('Notification has been sent successfully!');
                        } catch (\Exception $e) {
                            $this->info('Caught exception: ' . $e->getMessage());
                        }
                        
                    }
                } else {
                    $this->info("empty push subscription");
                }
            }
        } else {
            $this->info("empty reminders");
        }
    }
}
