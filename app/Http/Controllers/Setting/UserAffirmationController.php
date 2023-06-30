<?php

namespace App\Http\Controllers\Setting;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting\UserAffirmation;
use Illuminate\Support\Facades\Validator;

class UserAffirmationController extends Controller
{

    private $affirmation;
    public function __construct(UserAffirmation $affirmation)
    {
        $this->affirmation = $affirmation;
    }
    public function index()
    {
        return Inertia::render('Setting/OwnAffirmation');
    }

    public function store(Request $request)
    {
       
        $this->affirmation->storeOwnAffirmation($request->all());
        return redirect()->back();
    }
}
