<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Classes\ProductManager;
use Laravel\Cashier\Cashier;

class UserSubscriptionController extends Controller
{
    public function index()
    {
        $packages = ProductManager::make();
       
        return Inertia::render('Setting/BillingSubscription', [
            'packages' => $packages,
        ]); 
    }
   
    public function cancelSubscription(Request $request)
    {   
        try {
            auth()->user()->subscription('default')->cancel();
            return back()->with('success', 'Subscription has been cancelled successfully!');
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function resumeSubscription(Request $request)
    {
        try {
            if (auth()->user()->subscription('default')->onGracePeriod()) {
                auth()->user()->subscription('default')->resume();
            }
            return back()->with('success', 'Subscription has been resumed successfully!');
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();

        try {

            if ($user->hasDefaultPaymentMethod()) {
                $user->subscription('default')->swap($request->plan_id);
                return back()->with('success', 'Subscription has been resumed successfully!');
            } else {
                $url = $user->newSubscription($request->plan_name, $request->plan_id)
                    ->checkout([
                        'success_url' => route('setting.subscribe'),
                        'cancel_url'  => route('setting.subscribe')
                    ])->url;
            
                return Inertia::location($url);
            }

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        } 
        
    }

    public function addPaymentMethod()
    {
        $user = auth()->user();

        try {
            $url = $user->stripe()
                ->checkout
                ->sessions
                ->create([
                    'payment_method_types' => ['card'],
                    'mode' => 'setup',
                    'customer' => $user->asStripeCustomer(),
                    'success_url' => route('setting.subscribe'),
                    'cancel_url'  => route('setting.subscribe')
                ])->url;

            return Inertia::location($url);
            // return back()->with('checkout_url', $url);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deletePaymentMethod(Request $request)
    {
        $user = auth()->user();

        try {   
            $paymentMethod = $user->findPaymentMethod($request->paymentMethodId);
            if($paymentMethod) {
                $paymentMethod->delete();
            }
            return back()->with('success', 'Payment method has been removed successfully!');
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function setAsDefaultPayment(Request $request)
    {
        $user = auth()->user();

        try {   
            $user->updateDefaultPaymentMethod($request->paymentMethodId);
            $user->updateDefaultPaymentMethodFromStripe();

            return back()->with('success', 'Payment method has been set as default!');
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function downloadInvoice($invoiceId) 
    {
        return auth()->user()->downloadInvoice($invoiceId, [
           ...config('subscription.receipt_data') 
        ]);
    }
}
