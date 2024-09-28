<?php

namespace App\Providers;

use App\Models\Notifications;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $getNotifications = Notifications::with('users')
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get();

        View::share('getNotification', $getNotifications);
    }
}
