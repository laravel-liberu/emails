<?php

namespace LaravelEnso\Emails;

use LaravelEnso\Emails\app\Enums\Types;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    protected $register = [
        'emailTypes' => Types::class,
        'emailPriorities' => Priorities::class,
    ];
}
