<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersLoaderProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $file = app_path('Helpers/helpers.php');
        if (file_exists($file)) {
            require_once($file);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
