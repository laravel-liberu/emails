<?php

namespace LaravelEnso\Emails\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class PriorityLabels extends Enum
{
    protected static $data = [
        Priorities::High => 'is-danger',
        Priorities::Normal => 'is-warning',
        Priorities::Low => 'is-success',
    ];
}
