<?php

namespace LaravelEnso\Emails\App\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\App\Tables\Builders\EmailTable;
use LaravelEnso\Tables\App\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = EmailTable::class;
}
