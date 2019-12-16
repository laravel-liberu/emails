<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class RecipientTypes extends Enum
{
    public const To = 1;
    public const Cc = 2;
    public const Bcc = 3;
}
