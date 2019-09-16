<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;
use LaravelEnso\Emails\app\Services\MailManager;

class Send extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        (new MailManager($request, $email))->handle();
        
        return [
            'message' => __('The email was successfully sent'),
        ];
    }
}
