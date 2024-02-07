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
  UserSubscriptionController,
    UserThemeController
};

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
    Route::delete('/themes', 'deleteBackground')->name('themes.destroy');
    Route::get('/settings', 'settings')->name('settings');
    Route::post('/categories/active', 'setActiveCategory')->name('setCategory');
    Route::get('/calendar',[CalendarController::class,'index'])->name('calendar.index');
    Route::get('/chart',[ChartController::class,'index'])->name('chart.index');
  });

  Route::post('/themes/upload-image', [UserThemeController::class, 'uploadUserImage'])->name('themes.image-upload');
  Route::delete('/themes/delete-image/{background}', [UserThemeController::class, 'deleteUserImage'])->name('themes.delete');

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

 Route::controller(UserSubscriptionController::class)->group(function () {
   Route::get('/user/payment-method/add',  'addPaymentMethod')->name('payment-method.add');
   Route::post('/user/payment-method/delete',  'deletePaymentMethod')->name('payment-method.delete');
   Route::post('/user/payment-method/set-default',  'setAsDefaultPayment')->name('payment-method.default');

   Route::post('/subscription-checkout',  'subscribe')->name('checkout');
   Route::post('/subscription-cancel',  'cancelSubscription')->name('subscription.cancel');
   Route::post('/subscription-resume',  'resumeSubscription')->name('subscription.resume');

   Route::get('/user/invoice/{invoice}', 'downloadInvoice')->name('invoice.download');
 });

 Route::patch('/notification/newsletter', [UserController::class, 'updateNewsLetter'])->name('subscription.newsletter');
 Route::patch('/notification/appnotif', [UserController::class, 'updateAppNotif'])->name('subscription.appnotif');
});
Route::stripeWebhooks('stripe/webhook');
require __DIR__.'/auth.php';

Route::get('test-device', function(){
  dd(request()->server('HTTP_USER_AGENT'));
});
