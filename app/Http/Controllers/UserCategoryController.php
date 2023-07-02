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
            return auth()->user()->personalCategories();
        }

        UserCategories::create($request->validated());
        return back()->with('success', 'User category has been added successfully!');
    }

    public function update(UserCategoryRequest $request, UserCategories $userCateg)
    {
        $userCateg->update($request->validated());
        return back()->with('success', 'User category has been deleted successfully!');
    }

    public function destory(UserCategories $userCateg)
    {
        $userCateg->delete();
        return back()->with('success', 'User category has been deleted successfully!');
    }
}
