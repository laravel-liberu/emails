<?php

namespace LaravelEnso\Emails\App\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\App\Email;
use LaravelEnso\Emails\App\Http\Requests\ValidateEmailSendRequest;

class Send extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        $email->fill($request->mapped())->save();

        $email->syncRecipients()
            ->syncAttachments()
            ->send();

        return [
            'message' => __('The email was succesfully sent!'),
            'redirect' => 'emails.index',
        ];
    }
}
