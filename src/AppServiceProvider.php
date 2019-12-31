<?php

namespace LaravelEnso\Emails;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Emails\App\Email;
use LaravelEnso\Teams\App\Models\Team;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->methods()
            ->publish();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/emails.php', 'emails');

        return $this;
    }

    private function methods()
    {
        Team::addDynamicMethod('emails', fn () => $this->belongsToMany(Email::class));

        User::addDynamicMethod('emails', fn () => $this->belongsToMany(
            Email::class, 'email_recipients', 'email_id', 'recipient_id'
        )->withPivot('type'));

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('laravel-enso'),
        ], ['emails-config', 'enso-config']);
    }
}
