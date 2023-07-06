<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCategoryRequest;
use App\Models\UserCategories;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function store(UserCategoryRequest $request)
    {
        /**
         * TODO:
         * Check if user is premium to allow adding unlimited number
         * of category.
         */
        if(!auth()->user()->subscribed()) {
            $userCategories = UserCategories::where('user_id', auth()->id())->count();
            if($userCategories > 0) {
                return back()->withErrors(['error' => 'You need to subscribe to premium to add more categories']);
            }
        }

        UserCategories::create($request->validated() + ['user_id' => auth()->id()]);
        return back()->with('success', 'User category has been added successfully!');
    }

    public function update(UserCategoryRequest $request, UserCategories $userCateg)
    {
        $userCateg->update($request->validated());
        return back()->with('success', 'User category has been deleted successfully!');
    }

    public function destroy(UserCategories $userCateg)
    {
        $userCateg->delete();
        return back()->with('success', 'User category has been deleted successfully!');
    }
}
