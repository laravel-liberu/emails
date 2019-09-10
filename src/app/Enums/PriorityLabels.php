<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class PriorityLabels extends Enum
{
    protected static $data = [
        Priorities::High => 'is-danger',
        Priorities::Normal => 'is-warning',
        Priorities::Low => 'is-success',
    ];
}
