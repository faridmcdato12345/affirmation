<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SecurityController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Security');
    }

    public function update(User $user, Request $request)
    {
        $user->update($request->validated());
        return to_route('users.index');
    }
}
