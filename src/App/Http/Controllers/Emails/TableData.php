<?php

namespace LaravelEnso\Emails\App\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\App\Tables\Builders\EmailTable;
use LaravelEnso\Tables\App\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = EmailTable::class;
}
