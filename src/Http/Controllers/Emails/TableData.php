<?php

namespace LaravelLiberu\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelLiberu\Emails\Tables\Builders\Email;
use LaravelLiberu\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = Email::class;
}
