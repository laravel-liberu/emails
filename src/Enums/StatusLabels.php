<?php

namespace LaravelLiberu\Emails\Enums;

use LaravelLiberu\Enums\Services\Enum;

class StatusLabels extends Enum
{
    protected static array $data = [
        Statuses::Sent => 'is-success',
        Statuses::Scheduled => 'is-warning',
        Statuses::Draft => 'is-info',
    ];
}
