<?php

namespace App\Classes;
use Laravel\Cashier\Cashier;
use Stripe\StripeClient;

class ProductManager 
{
    public $plans;
    public $vendorInfo;
    public $activeSubscription;
    public $paymentMethods;
    public $defaultPaymentMethod;

    protected StripeClient $stripe;
    
    public function __construct()
    {
        $this->plans    = config('subscription.plans');
        $this->vendorInfo  = config('subscription.receipt_data');
        $this->stripe      = Cashier::stripe();

        //Get Prices
        $this->getPrices();

        //Get Active Subscription
        $this->getActiveSubscription();

        //Get Payment Methods
        $this->getPaymentMethods();
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
     | and checks if the subscription is still on 
     | grace period. 
     |
     */
    public function getActiveSubscription(): void 
    {
        //Bind the package here to show
        $this->activeSubscription = auth()->user()->subscription('default');
        
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
                if(auth()->user()->subscription('default')->onGracePeriod()) {
                    $this->activeSubscription['onGracePeriod'] = true;
                }
            }
        }
    }

    public function getPaymentMethods(): void
    {
        $this->paymentMethods = auth()->user()->paymentMethods();
        $this->defaultPaymentMethod = auth()->user()->defaultPaymentMethod();
    }
}