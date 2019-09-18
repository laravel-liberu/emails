<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class Statuses extends Enum
{
    const Sent = 1;
    const Scheduled = 2;
    const Draft = 3;
}
