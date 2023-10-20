<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\Category;
use App\Models\ExerciseResult;
use App\Models\Progress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ExerciseResultController extends Controller
{
    public $progress, $category;
    public function __construct(Progress $progress, Category $category)
    {
        $this->progress = $progress;
        $this->category = $category;
    }
    public function store(ExerciseRequest $request) 
    {
        try {
            Progress::findOrFail($request->safe()->only(['progress_id']));
            DB::beginTransaction();
            $message = [
                'success' => 'Exercise results saved',
                'info' => false,
            ];
            ExerciseResult::create($request->validated());
            Progress::where('user_id',auth()->user()->id)
            ->where('id',$request->safe()->only(['progress_id']))
            ->update(['status' => '1']);
            
            $categoryId =$this->progress->getCategory(auth()->user()->id);
            
            $checker = $this->category->getProgress(auth()->user()->id,$categoryId);
            if(count($checker->affirmations) == $checker->affirmations_count){
                $message['info'] = true;
            }
            DB::commit();
            return back()->with($message);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Something went wrong!']);
        }
        return response()->json([
            'success' => false, 
            'message' => 'Failed to match user and progress.'
        ]);
    }
}
