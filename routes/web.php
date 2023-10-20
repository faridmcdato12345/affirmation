<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
  HomeController, 
  UserController, 
  ChartController, 
  CalendarController,
    CategoryController,
    UserCategoryController, 
  UserAffirmationController,
  ComingSoonController
};
use App\Models\Affirmation;
use App\Models\Category;
use App\Models\ExerciseResult;
use App\Models\Progress;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

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

  Route::get('/coming-soon', [ComingSoonController::class,'index'])->name('coming-soon');
  
});
// Route::post('/report', [App\Http\Controllers\HomeController::class, 'report'])->name('report');
require __DIR__.'/auth.php';
