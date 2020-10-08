<?php

namespace LaravelEnso\Emails\Enums;

use LaravelEnso\Enums\Services\Enum;

class PriorityLabels extends Enum
{
    protected static array $data = [
        Priorities::High => 'is-danger',
        Priorities::Normal => 'is-warning',
        Priorities::Low => 'is-success',
    ];
}
