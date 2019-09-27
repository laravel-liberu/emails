<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Services\MailManager;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSaveRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailSaveRequest $request, Email $email)
    {
        (new MailManager($email, $request))->save();
        
        return [
            'message' => __('The email was successfully saved!'),
            'redirect' => 'emails.show',
            'params' => ['email' => $email->id],
        ];
    }
}
