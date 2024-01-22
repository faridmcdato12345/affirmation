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
        $this->info("start");
        date_default_timezone_get();
        $serverTimeNow = date("H:i");
        $this->info("server time: ".$serverTimeNow);
        $firebaseToken = PushSubscription::where('notifiable',1)->get();
        $webPush = new WebPush([
            "VAPID" => [
                "publicKey" => "BPPP43im220nXU30GVoHws2lU_R_nz1IZeyOFSEM1CzqCADXqjGEKS2WArCHtjJ7UHmDZRfrHVrqZFQYLiCT5BI",
                "privateKey" => "oLlTzEdeAT0fAd0Cd46yiKeii-_AETDFJUUGIWH_-c0",
                "subject" => env("APP_URL")
            ]
        ], [], 30, ['verify' => false]);
        // if($firebaseToken || count($firebaseToken) > 0){
            // $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
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
                                $this->info('Result: '. json_encode($result));
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
            
            // if(!$reminders->isEmpty()){
            //     $userId = [];
            //     $userMessage = $reminders;
            //     foreach ($reminders as $reminder) {
            //         $userId[] = $reminder->user_id;
            //     }
            //     $data = [
            //         "registration_ids" => $firebaseToken,
            //         "data" => [
            //             "title" => 'Affirm',
            //             "user" => $userId,
            //             "user_reminders" => $reminders,
            //             "icon" => env('APP_URL').'images/icons/128.png'
            //         ]
            //     ];
            //     $dataString = json_encode($data);
            
            //     $headers = [
            //         'Authorization: key=' . $SERVER_API_KEY,
            //         'Content-Type: application/json',
            //     ];
            
            //     $ch = curl_init();
            
            //     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            //     curl_setopt($ch, CURLOPT_POST, true);
            //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                    
            //     $response = curl_exec($ch);
            // }
        //}
    }
}
