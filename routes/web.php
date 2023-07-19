<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserAffirmationController;


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

  Route::put('user/{user}/switch-background', [UserController::class, 'switchBackground']);
  Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('deleteUser');
  Route::apiResource('/user-category', UserCategoryController::class)->only(['store', 'update', 'destroy']);
  Route::apiResource('/user-affirmation', UserAffirmationController::class)->only(['store', 'update', 'destroy']);
  Route::get('cache/affirmation',function(){
    dd(Auth::user()->getAffirmation());
  });
});

// Route::post('/report', [App\Http\Controllers\HomeController::class, 'report'])->name('report');

require __DIR__.'/auth.php';
require __DIR__.'/setting.php';


