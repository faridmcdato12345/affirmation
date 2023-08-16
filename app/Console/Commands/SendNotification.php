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
        $serverTimeNow = date("h:i:s");
        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
        if($firebaseToken || $firebaseToken->isNotEmpty()){
            $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
            $reminders = Reminder::select('time','status')->where([
                ['time','LIKE','%'.$serverTimeNow.'%'],
                ['status',true]
                ])->get();
            
            if($reminders || $reminders->isNotEmpty()){
                $userId = [];
                foreach ($reminders as $reminder) {
                    $userId[] = $reminder->user_id;
                }
                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title" => 'Affirm',
                        "body" => 'This is body',
                        "user" =>  $userId
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
