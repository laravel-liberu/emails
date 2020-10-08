<?php

namespace LaravelEnso\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\Http\Requests\ValidateEmailSendRequest;
use LaravelEnso\Emails\Models\Email;

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
