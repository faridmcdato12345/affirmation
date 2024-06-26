<?php

namespace App\Providers;

use App\Models\AccountabilityPartner;
use App\Models\AccountabilityPartnerNotification;
use App\Models\UserAffirmation;
use App\Models\UserBackground;
use App\Models\UserCategories;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const BILLING = '/settings/subscribe';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        Route::model('user_category', UserCategories::class);
        Route::model('user_affirmation', UserAffirmation::class);
        Route::model('accountabilityPartnerInvite', AccountabilityPartner::class);
        Route::model('exerciseReminder', AccountabilityPartnerNotification::class);
        Route::model('background', UserBackground::class);

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/setting.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
