<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\MenuComposer;

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
        View::composer('components.navbar', MenuComposer::class);

        View::composer('components.sidebar', function ($view) {
            $unreadFeedbackCount = \App\Models\Feedback::where('is_read', false)->count();
            $view->with('unreadFeedbackCount', $unreadFeedbackCount);
        });
    }
}
