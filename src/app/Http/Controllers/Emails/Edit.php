<?php

namespace LaravelEnso\Emails\App\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\App\Email;
use LaravelEnso\Emails\App\Http\Resources\Email as Resource;

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
