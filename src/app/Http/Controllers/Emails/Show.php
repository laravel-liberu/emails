<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Http\Resources\Email as Resource;

class Show extends Controller
{
    public function __invoke(Email $email)
    {
        $email->load(['cc', 'to', 'bcc', 'attachments.file']);
        return new Resource($email);
    }
}
