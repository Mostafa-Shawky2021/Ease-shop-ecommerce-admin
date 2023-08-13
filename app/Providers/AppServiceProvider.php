<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        //
        // $activeNotificationsCount = Notification::where('is_seen', 0)->count();
        // $notifications = Notification::orderBy('is_seen', 'asc')
        //     ->orderBy('id', 'desc')
        //     ->get();
        // View::composer(['template.header'], function ($view) use ($notifications, $activeNotificationsCount) {
        //     $view->with('activeNotificationsCount', $activeNotificationsCount)
        //         ->with('notifications', $notifications);
        // });
        if (env('APP_ENV') == 'production')  $url->forceScheme('https');

        Paginator::useBootstrapFive();
    }
}
