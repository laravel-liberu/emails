<?php

namespace LaravelEnso\Emails;

use LaravelEnso\Emails\Enums\Priorities;
use LaravelEnso\Emails\Enums\PriorityLabels;
use LaravelEnso\Emails\Enums\RecipientTypes;
use LaravelEnso\Emails\Enums\SendTo;
use LaravelEnso\Emails\Enums\Statuses;
use LaravelEnso\Emails\Enums\StatusLabels;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'emailStatuses' => Statuses::class,
        'emailSendTo' => SendTo::class,
        'emailPriorities' => Priorities::class,
        'emailStatusLabels' => StatusLabels::class,
        'emailRecipientTypes' => RecipientTypes::class,
        'emailPriorityLabels' => PriorityLabels::class,
    ];
}
