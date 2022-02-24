<?php

namespace LaravelEnso\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\Tables\Builders\Email;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = Email::class;
}
