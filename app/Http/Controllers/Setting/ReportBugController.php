<?php

namespace App\Http\Controllers\Setting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Setting\ReportBug;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportBugController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'description' => 'required'
        ],[
            'description' => 'You forgot to write something'
        ]);
        
        $user = Auth::user();
        $user->bug()->create($validated);

        return back()->with('success', 'Issue has been sent successfully!');
    }
}
