<?php

namespace LaravelEnso\Emails;

use LaravelEnso\Emails\App\Enums\Priorities;
use LaravelEnso\Emails\App\Enums\PriorityLabels;
use LaravelEnso\Emails\App\Enums\RecipientTypes;
use LaravelEnso\Emails\App\Enums\SendTo;
use LaravelEnso\Emails\App\Enums\Statuses;
use LaravelEnso\Emails\App\Enums\StatusLabels;
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
