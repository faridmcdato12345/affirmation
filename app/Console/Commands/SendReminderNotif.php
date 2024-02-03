<?php

namespace App\Console\Commands;

use App\Models\PushSubscription;
use App\Models\Reminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class SendReminderNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:push-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send push notification to user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_get();
        $serverTimeNow = date("H:i");
        $webPush = new WebPush([
            "VAPID" => [
                "publicKey" => "BPPP43im220nXU30GVoHws2lU_R_nz1IZeyOFSEM1CzqCADXqjGEKS2WArCHtjJ7UHmDZRfrHVrqZFQYLiCT5BI",
                "privateKey" => "oLlTzEdeAT0fAd0Cd46yiKeii-_AETDFJUUGIWH_-c0",
                "subject" => config('app.url')
            ]
        ], ["verify" => false]);

        $reminders = Reminder::query()
            ->where('dispatched', false)
            ->where('reminder_type', 'reminder')
            ->get();

        $this->info($serverTimeNow);

        if(!$reminders->isEmpty()){
            foreach ($reminders as $reminder) {
                $pushes = PushSubscription::where('user_id', $reminder->user_id)->where('notifiable', 1)->get();
                $dd = array("title" => "Affirmation","body" => $reminder->custom_message, "url" => env('APP_URL'));
                if(!$pushes->isEmpty()){
                    foreach($pushes as $push){
                        try {
                            DB::beginTransaction();
                            $webPush->sendOneNotification(
                                Subscription::create(json_decode($push->data, true)),
                                json_encode($dd)
                            );
                            $this->info('Success send notif');
                            $this->info(json_encode($reminder));
                            Reminder::where('id', $reminder->id)->first()->update(['dispatched' => true]);
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            $this->info('Caught exception: ' . $e->getMessage());
                        }
                    }
                } else {
                    $this->info("empty push subscription");
                }
            }
        } else { 
            $this->info("Empty accountability reminder");
        }

    }
}
