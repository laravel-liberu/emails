<?php

namespace LaravelEnso\Emails\app\Enums;

use LaravelEnso\Helpers\app\Classes\Enum;

class Priorities extends Enum
{
    const VeryImportant = 1;
    const Important = 2;
    const Normal = 3;

    protected static $data = [
        self::VeryImportant => 'Very Important',
        self::Important => 'Important',
        self::Normal => 'Normal',
    ];
}
