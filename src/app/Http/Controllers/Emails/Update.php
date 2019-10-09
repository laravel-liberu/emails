<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Helpers\app\Exceptions\EnsoException;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailRequest;

class Update extends Controller
{
    public function __invoke(ValidateEmailRequest $request, Email $email)
    {
        if($email->sent_at) {
            throw new EnsoException('You cannot edit an already sent email!');
        }
        
        $email->update($request->validated());
        
        return [
            'message' => __('The email was successfully updated!'),
        ];
    }
}
