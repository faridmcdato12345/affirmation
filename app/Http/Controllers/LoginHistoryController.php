<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use Inertia\Inertia;

class LoginHistoryController extends Controller
{
    public function index()
    {
        $data = LoginHistory::where('user_id', auth()->id())->get();
        return Inertia::render('Setting/LoginHistory', compact('data')); 
    }
}
