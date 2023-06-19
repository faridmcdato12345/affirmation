<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\NewPasswordController;
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
Route::middleware('auth')->group(function(){
  Route::get('/', function () {
    return Inertia::render('Welcome');
  })->name('welcome');
});
Route::get('/login', function () {
  return Inertia::render('Auth/Login');
})->name('login');
Route::post('/login',[LoginController::class,'login'])->name('post.login');

Route::get('/register',function () {
  return Inertia::render('Auth/Register');
})->name('register');
Route::post('/register',[RegisterController::class,'store'])->name('post.register');
Route::inertia('/forgot-password','Auth/ForgotPassword')->name('forgot.password');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
  ->middleware('guest')
  ->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
->name('password.reset');