<?php

namespace LaravelEnso\Emails\Enums;

use LaravelEnso\Enums\Services\Enum;

class SendTo extends Enum
{
    public const Users = 1;
    public const Teams = 2;
    public const All = 3;
}
