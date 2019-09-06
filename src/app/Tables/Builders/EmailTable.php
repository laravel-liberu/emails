<?php

namespace LaravelEnso\Emails\app\Tables\Builders;

use LaravelEnso\Emails\app\Email;
use LaravelEnso\Tables\app\Services\Table;

class EmailTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/emails.json';

    public function query()
    {
        return Email::selectRaw('
            emails.id as "dtRowId",emails.id,
            emails.subject, emails.body, emails.priority,
            emails.schedule_at, emails.sent_at, emails.created_by
        ');
    }
}
