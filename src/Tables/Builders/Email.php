<?php

namespace LaravelLiberu\Emails\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelLiberu\Emails\Models\Email as Model;
use LaravelLiberu\Tables\Contracts\Table;

class Email implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/emails.json';

    public function query(): Builder
    {
        return Model::selectRaw('
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
