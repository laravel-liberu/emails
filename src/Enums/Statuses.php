<?php

namespace LaravelEnso\Emails\Enums;

use LaravelEnso\Enums\Services\Enum;

class Statuses extends Enum
{
    public const Sent = 1;
    public const Scheduled = 2;
    public const Draft = 3;
}
