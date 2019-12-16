<?php

namespace LaravelEnso\Emails;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Emails\app\Email;
use LaravelEnso\Teams\app\Models\Team;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load();
        $this->loadMethods();
        $this->publish();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/emails.php', 'emails');
    }

    private function loadMethods()
    {
        Team::addDynamicMethod('emails', function () {
            return $this->belongsToMany(Email::class);
        });

        User::addDynamicMethod('emails', function () {
            return $this->belongsToMany(
                Email::class,
                'email_recipients',
                'email_id',
                'recipient_id'
            )->withPivot('type');
        });
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('laravel-enso'),
        ], 'emails-config');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'emails-assets');
    }
}
