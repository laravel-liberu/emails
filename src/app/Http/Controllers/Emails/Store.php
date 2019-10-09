<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Services\MailManager;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailRequest $request, Email $email)
    {
        (new MailManager($email, $request))->save();
        
        return [
            'message' => __('The email was successfully saved!'),
            'redirect' => 'emails.edit',
            'params' => ['email' => $email->id],
        ];
    }
}
