<?php

namespace LaravelEnso\Emails\Enums;

use LaravelEnso\Enums\Services\Enum;

class RecipientTypes extends Enum
{
    public const To = 1;
    public const Cc = 2;
    public const Bcc = 3;
}
