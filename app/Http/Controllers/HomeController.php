<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Reminder;
use App\Helpers\SendInBlue;
use Illuminate\Http\Request;
use App\Models\ExerciseResult;
use App\Models\UserBackground;
use App\Models\UserCategories;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Contracts\Database\Eloquent\Builder;

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

    public function index(Request $request)
    {
        $affirmation = Auth::user()->getAffirmation();
        $progressId = !is_null($affirmation) 
                        ? Auth::user()->progress()->where('affirmation_id',$affirmation['affirm']->id)
                        ->where('status','0')
                        ->first()
                        ->id
                        : null;
        $checkExerciseToday = ExerciseResult::with(['progress' => function($query){
            $query->where('user_id',auth()->user()->id);
        }])
        ->where('created_at','>',today())
        ->first();

        return Inertia::render('Index', [
            'affirmation'      => !is_null($affirmation) ? $affirmation['affirm'] : null,
            'progressId'       => $progressId,
            'exerciseFinished' => !is_null($affirmation) && count(collect($checkExerciseToday))
                                    ? true
                                    : false,
            'isSubscribed'     => Auth::user()->subscribedToPremium(),
            'isNotify'         => Auth::user()->isNotify,
            'userId'          => Auth::user()->id
        ]);
    }

    public function settings()
    {
        $user = Auth::user()->subscribedToPremium();
        return Inertia::render('Settings',['isUserSubscribe' => $user]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categories()
    {
        return Inertia::render('Categories', [
            'categories'         => Category::with(['affirmations' => function($query){
                                        $query->whereHas('progress',function(Builder $builder){
                                            $builder->where('user_id',auth()->id())->where('status','=','1');
                                        })->count();
                                    }])->withCount('affirmations')->get()->groupBy('premium'),
            'myCategories'       => UserCategories::where('user_id', auth()->id())->with(['affirmations'])->get(),
            'isPremium'          => Auth::user()->subscribed(),
            'activeCategory'     => Auth::user()->active_category_id,
            'activeCategoryType' => Auth::user()->active_category_type
        ]);
    }

    public function themes()
    {
        return Inertia::render('Themes', [
            'backgroundImages' => UserBackground::where('user_id', auth()->id())->get(['user_id', 'image'])
        ]);
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
        $user->update([
            'active_category_id' => $validated['category_id'],
            'active_category_type' => $request->type == 'personal' ? UserCategories::class : Category::class,
        ]);

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

    public function updateToken(Request $request)
    {
        try{
            if(isEmpty(auth()->user()->fcm_token)){
                auth()->user()->update([
                    'fcm_token'=>$request->fcm_token,
                    'isNotify' => $request->isNotify
                ]);
            }
            auth()->user()->update(['isNotify' => $request->isNotify]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }
}
