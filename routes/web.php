<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  HomeController, 
  UserController, 
  ChartController, 
  CalendarController,
    CategoryController,
    UserCategoryController, 
  UserAffirmationController
};
use App\Models\Affirmation;
use App\Models\Category;
use App\Models\Progress;
use Illuminate\Database\Eloquent\Builder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();

Route::middleware(['auth','verified'])->group(function () {

  Route::controller(HomeController::class)->group(function() {
    Route::get('/', 'index')->name('home');
    Route::get('/categories','categories')->name('categories');
    Route::get('/themes', 'themes')->name('themes');
    Route::get('/settings', 'settings')->name('settings');
    Route::post('/categories/active', 'setActiveCategory')->name('setCategory');
    Route::get('/calendar',[CalendarController::class,'index'])->name('calendar.index');
    Route::get('/chart',[ChartController::class,'index'])->name('chart.index');
  });

  Route::post('/themes/upload-image', [UserController::class, 'uploadUserImage'])->name('themes.image-upload');

  Route::put('user/{user}/switch-background', [UserController::class, 'switchBackground']);
  Route::post('/users/delete', [UserController::class, 'delete'])->name('deleteUser');
  Route::apiResource('/user-category', UserCategoryController::class)->only(['store', 'update', 'destroy']);
  Route::apiResource('/user-affirmation', UserAffirmationController::class)->only(['store', 'update', 'destroy']);

  Route::post('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');

  Route::put('/category/{id}',[CategoryController::class,'refresh'])->name('category.refresh');
  
});
// Route::post('/report', [App\Http\Controllers\HomeController::class, 'report'])->name('report');
require __DIR__.'/auth.php';

Route::get('/count/progress',function(){
  // $x = Category::with(['affirmations' => function($q){
  //   $q->whereHas('progress',function(Builder $query){
  //     $query->where('status','=','1')->where('user_id',3);
  //   });
  // }])
  // ->withCount('affirmations')
  // ->get();
  // dd($x);
  // $x = Category::with(['affirmations' => function($q){
  //   $q->whereDoesntHave('progress');
  // }])->first();
  // $y = collect($x->affirmations)->random(1)->first();
  // dd($y->id);
  //$x = Category::with('affirmations')->find(1);
  // $d = Category::with(['affirmations' => function ($query){
  //   $query->select()
  // }])->get();
  // dd($d);
    // $__dd = true;
    // $x = Affirmation::with('category')->where('id',242)->first();
    // //dd($x->category->id);
    // $y = Category::with(['affirmations' => function($q){
    //     $q->whereHas('progress',function(Builder $query){
    //       $query->where('status','=','1')->where('user_id',1);
    //     });
    //   }])
    //   ->withCount('affirmations')
    //   ->find($x->category->id);
    //   // dd(count($y->affirmations));
    // if($y->affirmations_count != count($y->affirmations)){
    //   $__dd = false;
    // }
    $message = [
        'success' => 'Exercise results saved',
        'is_complete' => false
    ];
    // $m = [
    //   'is_complete' => true
    // ];
    //dd($message);
    // $message['is_complete'] = true;
    // dd($message);
    // $x = Progress::with(['affirmation.category' => function($query){
    //   $query->select('id');
    // }])
    // ->where('status','1')
    // ->where('id',4)
    // ->first();
    // //dd($x->affirmation->category->id);
    // $y = Category::with(['affirmations' => function($q){
    //       $q->whereHas('progress',function(Builder $query){
    //         $query->where('status','=','1')->where('user_id',3);
    //       });
    //     }])
    //     ->withCount('affirmations')
    //     ->find($x->affirmation->category->id);
    // if(count($y->affirmations) != $y->affirmations_count){
    //   dd('not equal');
    // }
    $y = Category::find(1);
    //dd($y->affirmations[0]->progress->where('user_id', 3)->update(['status' => '0']));
    if($y){
      $y->affirmations->each(function ($affirmation) {
          //dd($affirmation->progress);
          $affirmation->progress->where('user_id', 3)->each(function ($progress) {
              $progress->update(['status' => '1']);
          });
      });
      
    }
    //dd($y);
});

