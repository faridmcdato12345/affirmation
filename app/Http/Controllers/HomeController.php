<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ExerciseResult;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SendInBlue;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

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
        $affirmation = Auth::user()->getAffirmation();
        $progressId = Auth::user()->progress()->where('created_at', '>', today())->first()->id;

        return Inertia::render('Index', [
            'affirmation'      => $affirmation,
            'progressId'       => $progressId,
            'exerciseFinished' => ExerciseResult::where('progress_id', $progressId)->exists(),
        ]);
    }

    /**
     * Show the application settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return Inertia::render('Settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        return Inertia::render('Categories', [
            'categories' => Category::all()->groupBy('premium'),
            'isPremium' => Auth::user()->subscribed(),
            'activeCategory' => Auth::user()->active_category
        ]);
    }

    public function themes()
    {
        return Inertia::render('Themes');
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

        return redirect()->route('categories', [
            'categories' => Category::all()->groupBy('premium'),
            'active' => 'categories',
            'activeCategory' => $user->active_category
        ]);
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

        $sib = new SendInBlue();
        try {
            $sib->sendReportEmail(Auth::user(), htmlspecialchars($request->contactMessageTextarea));
            return redirect()->route('settings', ['active' => 'settings'])->with('alert', 'Report saved. Thank you!');
        } catch (\Throwable $e) {
            Log::error($e);
            Log::warning('User Generated error report: ' . $request->contactMessageTextarea);
            return redirect()->route('settings', ['active' => 'settings'])->with('alert', 'Report saved. Thank you!');
        }
    }
}
