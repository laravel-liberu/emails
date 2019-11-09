<?php

namespace LaravelEnso\Emails\app\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Emails\app\Email;
use LaravelEnso\Tables\app\Contracts\Table;

class EmailTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/emails.json';

    public function query() : Builder
    {
        return Email::selectRaw('
            emails.id, emails.subject, emails.body, emails.priority, emails.created_at,
            emails.schedule_at, emails.sent_at,  people.name as createdBy
        ')->join('users', 'emails.created_by', '=', 'users.id')
        ->join('people', 'users.person_id', '=', 'people.id');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
