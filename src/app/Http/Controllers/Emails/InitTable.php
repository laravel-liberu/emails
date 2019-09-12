<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Init;
use LaravelEnso\Emails\app\Tables\Builders\EmailTable;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = EmailTable::class;
}
