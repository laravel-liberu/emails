<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class SendTo extends Enum
{
    public const Users = 1;
    public const Teams = 2;
    public const All = 3;
}
