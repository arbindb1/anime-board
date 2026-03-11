<?php

namespace App\Providers;

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
        // Share available group names globally for the forms
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            // Only pull group names on anime pages to be efficient
            if (str_contains(request()->path(), 'anime')) {
                $groups = \App\Models\Anime::whereNotNull('group_name')
                    ->where('group_name', '!=', '')
                    ->distinct()
                    ->pluck('group_name');
                $view->with('availableGroups', $groups);
            } else {
                $view->with('availableGroups', collect([]));
            }
        });
    }
}
