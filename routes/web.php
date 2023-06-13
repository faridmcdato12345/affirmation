<?php

use Illuminate\Support\Facades\Route;
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

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/categories', [App\Http\Controllers\HomeController::class, 'categories'])->name('categories');

// Route::post('/categories/active', [App\Http\Controllers\HomeController::class, 'setActiveCategory'])->name('setCategory');

// Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');

// Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('deleteUser');

// Route::post('/report', [App\Http\Controllers\HomeController::class, 'report'])->name('report');

Route::get('/inertia-welcome', function () {
  return Inertia::render('Welcome');
})->name('inertia-welcome');

Route::get('/inertia-login', function () {
  sleep(2);
  return Inertia::render('Auth/Login');
})->name('inertia-login');