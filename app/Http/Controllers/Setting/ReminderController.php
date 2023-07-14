<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ReminderController extends Controller
{
    public function index()
    {
        return Inertia::render('Setting/Reminder');
    }
}
