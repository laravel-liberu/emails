<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Email;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailRequest;
use LaravelEnso\Emails\app\Services\MailManager;

class Update extends Controller
{
    public function __invoke(ValidateEmailRequest $request, Email $email)
    {
        (new MailManager($email, $request))->update();

        return [
            'message' => __('The email was successfully updated!'),
        ];
    }
}
