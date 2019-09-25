<?php

namespace LaravelEnso\Emails;

use LaravelEnso\Emails\app\Enums\SendTo;
use LaravelEnso\Emails\app\Enums\Statuses;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Emails\app\Enums\StatusLabels;
use LaravelEnso\Emails\app\Enums\PriorityLabels;
use LaravelEnso\Emails\app\Enums\RecipientTypes;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    protected $register = [
        'emailStatuses' => Statuses::class,
        'emailSendTo' => SendTo::class,
        'emailPriorities' => Priorities::class,
        'emailStatusLabels' => StatusLabels::class,
        'emailRecipientTypes' => RecipientTypes::class,
        'emailPriorityLabels' => PriorityLabels::class,
    ];
}
