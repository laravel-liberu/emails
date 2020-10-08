<?php

namespace LaravelEnso\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\Http\Resources\Email as Resource;
use LaravelEnso\Emails\Models\Email;

class Edit extends Controller
{
    public function __invoke(Email $email)
    {
        $email->load([
            'cc', 'to', 'bcc', 'teams', 'attachments.file',
        ]);

        return new Resource($email);
    }
}
