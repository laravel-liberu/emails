<?php

namespace LaravelLiberu\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelLiberu\Emails\Tables\Builders\Email;
use LaravelLiberu\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = Email::class;
}
