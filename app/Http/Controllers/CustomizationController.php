<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CustomizationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Customize', [
            'newsLetterSubscription' => $user->newsletter_subscription,
            'appNotifSubscription' => $user->app_notifications_subscription
        ]);
    }
}
