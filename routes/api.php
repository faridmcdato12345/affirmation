<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AffirmationController;
use App\Http\Controllers\ExerciseResultController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('categories.affirmations', AffirmationController::class)->shallow();

Route::get('affirmation', [UserController::class, 'getAffirmation']);
Route::apiResource('affirmations', AffirmationController::class)->only(['index', 'show']);
