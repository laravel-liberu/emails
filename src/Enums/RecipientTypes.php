<?php

namespace LaravelLiberu\Emails\Enums;

use LaravelLiberu\Enums\Services\Enum;

class RecipientTypes extends Enum
{
    public const To = 1;
    public const Cc = 2;
    public const Bcc = 3;
}
