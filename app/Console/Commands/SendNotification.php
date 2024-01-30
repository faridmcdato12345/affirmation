<?php

namespace App\Console\Commands;

use App\Models\PushSubscription;
use DateTime;
use DateTimeZone;
use App\Models\User;
use App\Models\Reminder;
use Illuminate\Console\Command;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Json;

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
        $firebaseToken = PushSubscription::where('notifiable',1)->get();
        $webPush = new WebPush([
            "VAPID" => [
                "publicKey" => "BJG1XAHzzuZY2VTgKvvycBKikvRJXFpswILkTQa1a1Ot3iaGajndVpEYy288-nhKq_4kAAbFOobYBenfMGVJPfI",
                "privateKey" => "A4MgZic6q7n8bRbZmRp2_lg5WSoh2gmy2cG-Scgy1Uk",
                "subject" => env("APP_URL")
            ]
        ], ["verify" => false]);
            $reminders = Reminder::select('user_id','time','status','custom_message','original_time')
                ->where('time',$serverTimeNow)
                ->where('status',true)
                ->get();
            if(!$reminders->isEmpty()){
                foreach ($reminders as $reminder) {
                    $pushes = PushSubscription::where('user_id',$reminder->user_id)->where('notifiable',1)->get();
                    $dd = array("title" => "Affirmation","body" => $reminder->custom_message, "url" => env('APP_URL'));
                    $this->info("json: " . json_encode($dd));
                    if(!$pushes->isEmpty()){
                        foreach($pushes as $push){
                            try {
                                $result = $webPush->sendOneNotification(
                                    Subscription::create(json_decode($push->data, true)),
                                    json_encode($dd)
                                );
                                $this->info('Success send notif');
                            } catch (\Exception $e) {
                                $this->info('Caught exception: ' . $e->getMessage());
                            }
                            
                        }
                    }else{
                        $this->info("empty push subscription");
                    }
                }
            }else{
                $this->info("empty reminders");
            }
    }
}
