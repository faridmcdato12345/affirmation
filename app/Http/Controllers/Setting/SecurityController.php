<?php

namespace App\Http\Controllers\Setting;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function index()
    {
        return Inertia::render('Setting/Security', [
            'user' => Auth::user()
        ]);
    }

    public function update(PasswordUpdateRequest $request)
    {

        $request->user()->password = Hash::make($request->password);
        $request->user()->save();

        $request->session()->regenerateToken();

        return back()->with('success', 'Password has been updated successfully!');

    }
}
