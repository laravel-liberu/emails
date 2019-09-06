<?php

namespace LaravelEnso\Emails;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load();
        $this->publish();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/emails.php', 'emails');
    }

    private function publish()
    {
        $this->publishes([
            __DIR__ . '/config' => config_path('laravel-enso'),
        ], 'emails-config');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'emails-assets');
    }

    public function register()
    {
        //
    }
}
