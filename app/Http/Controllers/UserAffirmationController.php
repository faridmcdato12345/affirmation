<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAffirmationRequest;
use App\Http\Requests\UserAffirmationUpdateRequest;
use App\Models\UserAffirmation;
use App\Models\UserCategories;
use Illuminate\Http\Request;

class UserAffirmationController extends Controller
{
    public function store(UserAffirmationRequest $request)
    {
        if(!auth()->user()->subscribed()) {
            $userCategories = UserCategories::where('user_id', auth()->id())->withCount('affirmations')->first();

            if($userCategories->affirmations_count > 9) {
                return back()->withErrors(['error' => 'You need to subscribe to premium to add more affirmations']);
            }
        }

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
