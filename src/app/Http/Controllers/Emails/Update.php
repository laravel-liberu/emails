<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailRequest;

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
