<?php

namespace LaravelEnso\Emails\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class StatusLabels extends Enum
{
    protected static array $data = [
        Statuses::Sent => 'is-success',
        Statuses::Scheduled => 'is-warning',
        Statuses::Draft => 'is-info',
    ];
}
