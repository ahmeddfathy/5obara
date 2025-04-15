<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        // إضافة المصادقة الأساسية HTTP لمسارات تسجيل الدخول
        $this->secureAuthRoutes();
    }

    /**
     * تأمين مسارات المصادقة بواسطة المصادقة الأساسية HTTP
     */
    protected function secureAuthRoutes(): void
    {
        // تطبيق ميدلوير basic.auth على مسارات المصادقة
        Route::middleware(['basic.auth', 'security.headers', 'sql.injection'])
            ->group(function () {
                Route::get('/login', function () {
                    return app()->handle(Request::create('/login', 'GET'));
                });

                // تطبيق brute.force على مسار POST للتسجيل الدخول
                Route::post('/login', function (Request $request) {
                    // الحماية ضد هجمات brute force مطبقة مباشرة على هذا المسار
                    return app()->handle(Request::create('/login', 'POST', $request->all()));
                })->middleware(['brute.force', 'account.takeover']);

                Route::post('/logout', function (Request $request) {
                    return app()->handle(Request::create('/logout', 'POST', $request->all()));
                });
            });
    }
}
