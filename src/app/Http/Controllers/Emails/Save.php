<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Services\MailManager;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSaveRequest;

class Save extends Controller
{
    public function __invoke(ValidateEmailSaveRequest $request, Email $email)
    {
        (new MailManager($email, $request))->save();
        
        return [
            'message' => __('The email was successfully saved!'),
        ];
    }
}
