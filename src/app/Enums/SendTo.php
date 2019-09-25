<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class SendTo extends Enum
{
    const Users = 1;
    const Teams = 2;
    const All = 3;
}
