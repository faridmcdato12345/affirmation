<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


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
  });

  Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('deleteUser');

  
});

// Route::post('/report', [App\Http\Controllers\HomeController::class, 'report'])->name('report');

require __DIR__.'/auth.php';
require __DIR__.'/setting.php';
