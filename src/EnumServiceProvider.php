<?php

namespace LaravelEnso\Emails;

use LaravelEnso\Emails\app\Enums\Types;
use LaravelEnso\Emails\app\Enums\Statuses;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Emails\app\Enums\StatusLabels;
use LaravelEnso\Emails\app\Enums\PriorityLabels;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    protected $register = [
        'emailTypes' => Types::class,
        'emailPriorities' => Priorities::class,
        'emailPriorityLabels' => PriorityLabels::class,
        'emailStatuses' => Statuses::class,
        'emailStatusLabels' => StatusLabels::class,
    ];
}
