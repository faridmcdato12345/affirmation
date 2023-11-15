<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Classes\ProductManager;

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
            $request->user()->subscription('default')->cancel();
            return back()->with('success', 'Subscription has been cancelled successfully!');
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function resumeSubscription(Request $request)
    {
        try {
            if (auth()->user()->subscription('default')->onGracePeriod()) {
                $user->subscription('default')->resume();
            }
        } catch(\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function subscribe()
    {
        $url = auth()->user()
            ->newSubscription($request->plan_name, $request->plan_id)
            ->checkout([
            'success_url' => route('home'),
            'cancel_url'  => route('setting.subscribe')
            ])->url;
    
        return Inertia::location($url);
    }
}
