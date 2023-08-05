<?php

namespace App\Http\Controllers\Setting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Setting\ReportBug;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportBugController extends Controller
{
    public function index()
    {
        return Inertia::render('Setting/ReportBug');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'description' => 'required'
        ],[
            'description' => 'You forgot to write something'
        ]);
        $user = Auth::user();
        $user->bug()->create($validated);
        return redirect()->route('setting.reportbug.index');
    }
}
