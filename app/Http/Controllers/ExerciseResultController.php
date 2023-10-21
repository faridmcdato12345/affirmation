<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExerciseRequest;
use App\Models\Category;
use App\Models\ExerciseResult;
use App\Models\Progress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

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
        DB::beginTransaction();
        try {
            Progress::findOrFail($request->safe()->only(['progress_id']));
            
            $message = [
                'success' => 'Exercise results saved',
                'info' => false,
            ];
            
            Progress::where('user_id',auth()->id())
            ->where('id',$request->safe()->only(['progress_id']))
            ->update(['status' => '1']);
            ExerciseResult::create($request->validated());
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
