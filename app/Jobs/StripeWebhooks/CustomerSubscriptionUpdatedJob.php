<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;
use Spatie\WebhookClient\Models\WebhookCall;

class CustomerSubscriptionUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public WebhookCall $webhookCall) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->webhookCall->payload['data']['object'];

        $user = User::where('stripe_id', $data['customer'])->first();

        if($user) {
            //Set Default Payment Method if none
            if(!$user->hasDefaultPaymentMethod()) {
                $user->updateDefaultPaymentMethod($data['default_payment_method']);
            }

            //Create Subscription Item 
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'name' => 'default',
                'stripe_id' => $data['id'],
                'stripe_status' =>  $data['status'],
                'stripe_price' => $data['plan']['id'],
                'quantity' => $data['quantity']
            ]);
            
            SubscriptionItem::create([
                'subscription_id' => $subscription->id,
                'stripe_id' => $data['id'],
                'stripe_price' => $data['plan']['id'],
                'quantity' => $data['quantity'],
                'stripe_product' => $data['plan']['product']
            ]);
        }
    }
}
