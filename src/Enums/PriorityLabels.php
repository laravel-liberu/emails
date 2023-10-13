<?php

namespace LaravelLiberu\Emails\Enums;

use LaravelLiberu\Enums\Services\Enum;

class PriorityLabels extends Enum
{
    protected static array $data = [
        Priorities::High => 'is-danger',
        Priorities::Normal => 'is-warning',
        Priorities::Low => 'is-success',
    ];
}
