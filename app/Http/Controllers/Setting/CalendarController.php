<?php

namespace App\Http\Controllers\Setting;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ExerciseResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseResultResource;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index()
    {
        $exerciseResult = $this->user->getExerciseResult();
        // dd($exerciseResult->toArray());
        return Inertia::render('Setting/Calendar',[
            'results' => $exerciseResult->toArray()
        ]);
    }
}
