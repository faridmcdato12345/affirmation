<?php

namespace App\Http\Controllers\Setting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        return Inertia::render('Setting/Feedback');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required'
        ],[
            'description' => 'You forgot to write something.'
        ]);
        $user = Auth::user();
        $user->feedback()->create($validated);
        return redirect()->route('setting.feedback.index');
    }
}
