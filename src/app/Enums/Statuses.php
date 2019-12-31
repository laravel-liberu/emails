<?php

namespace LaravelEnso\Emails\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class Statuses extends Enum
{
    public const Sent = 1;
    public const Scheduled = 2;
    public const Draft = 3;
}
