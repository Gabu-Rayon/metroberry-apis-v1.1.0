<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Language;

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
    
    public function boot()
    {
        view()->composer('*', function ($view) {
            $languages = Language::pluck('full_name', 'code')->toArray();
            $currentLang = session('applocale', config('app.locale'));
            $view->with('languages', $languages);
            $view->with('lang', $currentLang);
        });
    }

}