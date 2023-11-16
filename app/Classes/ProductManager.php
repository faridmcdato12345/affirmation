<?php

namespace App\Classes;

use Carbon\Carbon;
use Laravel\Cashier\Cashier;
use Stripe\StripeClient;

class ProductManager 
{
    public $plans;
    public $activeSubscription;
    public $paymentMethods;
    public $invoices;
    public $defaultPaymentMethod;
    public $user;

    protected StripeClient $stripe;
    
    public function __construct()
    {
        $this->plans    = config('subscription.plans');
        $this->stripe   = Cashier::stripe();
        $this->user     = auth()->user();

        //Get Prices
        $this->getPrices();

        //Get Active Subscription
        $this->getActiveSubscription();

        //Get Payment Methods
        $this->getPaymentMethods();

        //Get Invoices
        $this->getInvoices();
    }

    public static function make()
    {
        return new static();
    }

    public function getPrices()
    {
        foreach($this->plans as $key => $package) {
          $this->plans[$key]['item']['monthly'] = $this->stripe->prices->retrieve($package['monthly_id'], []);
          $this->plans[$key]['item']['yearly'] = $this->stripe->prices->retrieve($package['yearly_id'], []);
        }
    }
   
    /*
     |----------------------------------------------------------------------
     | Get Active User Subscription
     |----------------------------------------------------------------------
     | Returns the current active subscription of the user
     | and checks if the subscription is still on grace period. 
     |
     |
     */
    protected function getActiveSubscription(): void 
    {
        //Bind the package here to show
        $this->activeSubscription = $this->user->subscription('default');
        
        //If no active subscription return 
        if(!$this->activeSubscription) return;

        foreach($this->plans as $package) {
            if ($package['monthly_id'] === $this->activeSubscription['stripe_price']) {
                $this->activeSubscription['plan'] = $package;
            }

            if ($package['yearly_id'] === $this->activeSubscription['stripe_price']) {
                $this->activeSubscription['plan'] = $package;
            }

            if(isset($this->activeSubscription['plan'])) {
                $this->activeSubscription['currentPeriodEnd'] = Carbon::createFromTimestamp($this->user
                    ->subscription('default')
                    ->asStripeSubscription()->current_period_end)
                    ->toFormattedDateString();
                $this->activeSubscription['onGracePeriod'] = $this->user->subscription('default')->onGracePeriod();
                $this->activeSubscription['amount'] = $this->stripe
                    ->prices
                    ->retrieve($this->activeSubscription['stripe_price']);
            }
        }
    }

    protected function getPaymentMethods(): void
    {
        $this->paymentMethods = $this->user->paymentMethods();
        $this->defaultPaymentMethod = $this->user->defaultPaymentMethod();
    }

    protected function getInvoices()
    {
        $this->invoices = $this->user->invoices()->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'date' => $invoice->date()->toFormattedDateString(),
                'total' => $invoice->total(),
                'paid' => $invoice->paid
            ];
        });
    }
}