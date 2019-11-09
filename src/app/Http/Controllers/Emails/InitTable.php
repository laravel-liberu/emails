<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Tables\Builders\EmailTable;
use LaravelEnso\Tables\app\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = EmailTable::class;
}
