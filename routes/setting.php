<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Setting\CalendarController;
use App\Http\Controllers\Setting\ChartController;
use App\Http\Controllers\Setting\FeedbackController;
use App\Http\Controllers\Setting\UserAffirmationController;
use App\Http\Controllers\Setting\ReportBugController;
use App\Http\Controllers\Setting\SecurityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('/settings')
    ->name('setting.')
    ->group(function(){
        Route::get('/account',[UserController::class,'show'])->name('user.index');
        Route::patch('/account/{user}',[UserController::class,'update'])->name('user.update');

        Route::get('/security',[SecurityController::class,'index'])->name('security.index');
        Route::patch('/security',[SecurityController::class,'update'])->name('security.update');

        Route::get('/report_bug',[ReportBugController::class,'index'])->name('reportbug.index');
        Route::post('/report_bug',[ReportBugController::class,'store'])->name('reportbug.store');

        Route::get('/feedback',[FeedbackController::class,'index'])->name('feedback.index');
        Route::post('/feedback',[FeedbackController::class,'store'])->name('feedback.store');

        Route::get('/user_affirmation',[UserAffirmationController::class,'index'])->name('useraffirmation.index');
        Route::post('/user_affirmation',[UserAffirmationController::class,'store'])->name('useraffirmation.store');

        Route::get('/calendar',[CalendarController::class,'index'])->name('calendar.index');

        Route::get('/chart',[ChartController::class,'index'])->name('chart.index');

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

    });
});
