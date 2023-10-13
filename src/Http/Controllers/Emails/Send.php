<?php

namespace LaravelLiberu\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelLiberu\Emails\Http\Requests\ValidateEmailSend;
use LaravelLiberu\Emails\Models\Email;

class Send extends Controller
{
    public function __invoke(ValidateEmailSend $request, Email $email)
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
