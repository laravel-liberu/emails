<?php

namespace LaravelLiberu\Emails;

use LaravelLiberu\Emails\Enums\Priorities;
use LaravelLiberu\Emails\Enums\PriorityLabels;
use LaravelLiberu\Emails\Enums\RecipientTypes;
use LaravelLiberu\Emails\Enums\SendTo;
use LaravelLiberu\Emails\Enums\Statuses;
use LaravelLiberu\Emails\Enums\StatusLabels;
use LaravelLiberu\Enums\EnumServiceProvider as ServiceProvider;

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
