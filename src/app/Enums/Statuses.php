<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class Statuses extends Enum
{
    public const Sent = 1;
    public const Scheduled = 2;
    public const Draft = 3;
}
