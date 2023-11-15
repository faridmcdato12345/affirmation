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
  ComingSoonController,
  ExerciseResultController,
    UserSubscriptionController
};
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spark\Http\Controllers\NewSubscriptionController;

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
  Route::patch('/users/hide-intro', [UserController::class, 'hideIntroduction'])->name('intro.hide');
  Route::patch('/users/show-intro', [UserController::class, 'showIntroduction'])->name('intro.show');
  Route::apiResource('/user-category', UserCategoryController::class)->only(['store', 'update', 'destroy']);
  Route::apiResource('/user-affirmation', UserAffirmationController::class)->only(['store', 'update', 'destroy']);

  Route::post('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');

  Route::put('/category/{id}',[CategoryController::class,'refresh'])->name('category.refresh');

  Route::get('/coming-soon', [ComingSoonController::class,'index'])->name('coming-soon');
  Route::post('exercise', [ExerciseResultController::class, 'store'])->name('exercise.store');

  Route::post('/subscription-checkout', [UserSubscriptionController::class, 'subscribe'])->name('checkout');
  Route::post('/subscription-cancel', [UserSubscriptionController::class, 'cancelSubscription'])->name('subscription.cancel');
  Route::post('/subscription-resume', [UserSubscriptionController::class, 'resumeSubscription'])->name('subscription.resume');
});


require __DIR__.'/auth.php';
