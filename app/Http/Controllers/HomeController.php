<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('affirmation', [
            'affirmation' => Auth::user()->getAffirmation(), 
            'progress_id' => Auth::user()->progress()->where('created_at', '>', today())->first()->id , 
            'active' => 'home'
        ]);
    }

    /**
     * Show the application settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return view('settings', ['active' => 'settings']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        $user = Auth::user();
        return view('categories', ['categories' => Category::all(), 'active' => 'categories', 'activeCategory' => $user->active_category]);
    }

    /**
     * Set a user's active category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setActiveCategory(Request $request)
    {
        $validated = $request->validate([
        'category_id' => 'required|integer',
        ]);

        $user = Auth::user();
        $user->active_category = $validated['category_id'];
        $user->save();
        return redirect()->route('categories', ['categories' => Category::all(), 'active' => 'categories', 'activeCategory' => $user->active_category]);
    }

    /**
     * Log A Report Submitted By a User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function report(Request $request)
    {
        $user = Auth::user();
        // TODO: SEND EMAIL
        return redirect()->route('settings', ['active' => 'settings'])->with('alert', 'Report saved. Thank you!');
    }
}
