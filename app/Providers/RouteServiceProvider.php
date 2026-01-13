<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting(): void
    {
        // Default API limiter (keep this)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                optional($request->user())->id ?: $request->ip()
            );
        });

        // Dedicated login limiter (add this)
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->input('email');

            return [
                // Per-IP protection
                Limit::perMinute(10)->by($request->ip()),

                // Per email + IP protection (prevents targeting one account)
                Limit::perMinute(5)->by(strtolower($email).'|'.$request->ip()),
            ];
        });
    }
}
