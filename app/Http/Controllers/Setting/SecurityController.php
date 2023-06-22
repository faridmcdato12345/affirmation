<?php

namespace App\Http\Controllers\Setting;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class SecurityController extends Controller
{
    public function index()
    {
        return Inertia::render('Setting/Security',['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if(!Hash::check($request->old_password, Auth::user()->password)){
            return false;
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME);
    }
}
