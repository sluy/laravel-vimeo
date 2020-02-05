<?php

namespace Vientodigital\LaravelVimeo;

use Illuminate\Support\ServiceProvider;

class LaravelVimeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-vimeo');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-vimeo');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-vimeo.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-vimeo'),
            ], 'views');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-vimeo');

        $this->app->singleton('laravel-vimeo', function () {
            return new LaravelVimeo();
        });
    }
}
