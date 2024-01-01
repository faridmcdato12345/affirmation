<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\Setting\FeedbackController;
use App\Http\Controllers\Setting\ReminderController;
use App\Http\Controllers\Setting\ReportBugController;
use App\Http\Controllers\Setting\SecurityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubscriptionController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('/settings')
    ->name('setting.')
    ->group(function(){
        Route::get('/account', [UserController::class, 'show'])->name('user.index');
        Route::patch('/account/{user}', [UserController::class,'update'])->name('user.update');
        
        Route::get('/account/partner', [UserController::class, 'accountabilityPartner'])->name('user.accountability');
        Route::delete('/account/{accountabilityPartnerInvite}', [UserController::class, 'deleteInvite'])->name('accountability.delete');
        Route::patch('/account/{accountabilityPartnerInvite}/approve', [UserController::class, 'approveInvite'])->name('accountability.approve');
        Route::post('/account/partner/invite', [UserController::class, 'sendInvite'])->name('accountability.invite');
        Route::post('/account/partner/remind', [UserController::class, 'remindPartner'])->name('accountability.remind');
        
        Route::patch('/partner/mark-as-read/{exerciseReminder}', [UserController::class, 'markAsRead'])->name('reminder.read');

        Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
        Route::patch('/security', [SecurityController::class, 'update'])->name('security.update');

        Route::post('/report_bug', [ReportBugController::class, 'store'])->name('reportbug.store');

        Route::get('/loginhistory', [LoginHistoryController::class, 'index'])->name('history.index');
        
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [FeedbackController::class, 'storeFeedback'])->name('feedback.store');

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
        Route::post('/reminder', [ReminderController::class, 'store'])->name('reminder.store');

        Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');

        Route::patch('/reminder/{reminder}', [ReminderController::class, 'update'])->name('reminder.update');
        Route::delete('/reminder/{reminder}', [ReminderController::class, 'delete'])->name('reminder.delete');

        Route::patch('/reminder/status/{reminder}', [ReminderController::class, 'changeStatus'])->name('reminder.status.update');
        Route::get('/subscribe', [UserSubscriptionController::class, 'index'])->name('subscribe');
    });
});
