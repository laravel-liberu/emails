<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class RecipientTypes extends Enum
{
    const To = 1;
    const Cc = 2;
    const Bcc = 3;
}
