<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider::class);
        config([
            'cloudinary.cloud_url' => env('CLOUDINARY_URL'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Redirect to admin login page if not authenticated
        Authenticate::redirectUsing(function ($request) {
            return route('admin.login');
        });

        // Share user data to all views
        View::composer('*', function ($view) {
            if (Request::is('admin/*') && Auth::check()) {
                $view->with('user', User::with('role')->find(Auth::id()));
            } else {
                $view->with('user', null);
            }
        });
    }
}
