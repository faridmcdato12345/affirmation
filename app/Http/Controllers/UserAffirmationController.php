<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAffirmationRequest;
use App\Http\Requests\UserAffirmationUpdateRequest;
use App\Models\UserAffirmation;
use Illuminate\Http\Request;

class UserAffirmationController extends Controller
{
    public function store(UserAffirmationRequest $request)
    {
       /**
         * TODO:
         * Check if user is premium to allow adding unlimited number
         * of category.
         */
        UserAffirmation::create($request->validated());
        return back()->with('success', 'Affirmation has been saved successfully!');
    }

    public function update(UserAffirmation $affirmation, UserAffirmationUpdateRequest $request)
    {
        $affirmation->update($request->validated());
        return back()->with('success', 'Affirmation has been updated successfully!');
    }

    public function destroy(UserAffirmation $affirmation)
    {
        $affirmation->delete();
        return back()->with('success', 'Affirmation has been deleted successfully!');
    }
}
