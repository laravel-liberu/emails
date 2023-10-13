<?php

namespace LaravelLiberu\Emails;

use Illuminate\Support\ServiceProvider;
use LaravelLiberu\Core\Models\User;
use LaravelLiberu\Teams\Models\Team;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->methods();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        return $this;
    }

    private function methods()
    {
        //TODO refactor to the new architecture
        Team::addDynamicMethod('emails', fn () => $this->belongsToMany(Email::class));

        User::addDynamicMethod('emails', fn () => $this->belongsToMany(
            Email::class,
            'email_recipients',
            'email_id',
            'recipient_id'
        )->withPivot('type'));
    }
}
