<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Delete a user account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request) {
        $user = $request->user();
        if (Hash::check($request->password, $user->password)) {
            $user->delete();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return view('auth.login');
        } else {
            return view('settings', ['active' => 'settings'])->withErrors(['msg' => 'The provided password does not match.']);
        }
    }

    /**
     * Return a daily affirmation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAffirmation(Request $request)
    {
        return Auth::user()->getAffirmation();
    }
}
