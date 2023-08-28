<?php

namespace App\Console\Commands;

use DateTime;
use DateTimeZone;
use App\Models\User;
use App\Models\Reminder;
use Illuminate\Console\Command;

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
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
        if($firebaseToken || count($firebaseToken) > 0){
            $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
            $reminders = Reminder::select('user_id','time','status','custom_message','original_time')
                ->where('time',$serverTimeNow)
                ->where('status',true)
                ->get();
            if(!$reminders->isEmpty()){
                $userId = [];
                $userMessage = $reminders;
                foreach ($reminders as $reminder) {
                    $userId[] = $reminder->user_id;
                }
                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title" => 'Affirm',
                        "icon" => public_path('images/icons/128.png'),
                    ],
                    "data" => [
                        "user" => $userId,
                        "user_reminders" => $reminders
                    ]
                ];
                $dataString = json_encode($data);
            
                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
            
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                    
                $response = curl_exec($ch);
            }
        }
    }
}
