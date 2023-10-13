<?php

namespace LaravelLiberu\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelLiberu\Emails\Http\Requests\ValidateEmail;
use LaravelLiberu\Emails\Models\Email;

class Store extends Controller
{
    public function __invoke(ValidateEmail $request, Email $email)
    {
        $email->fill($request->mapped())->save();

        $email->syncRecipients()
            ->syncAttachments()
            ->send();

        return [
            'message' => __('The email was successfully saved!'),
            'redirect' => 'emails.edit',
            'params' => ['email' => $email->id],
        ];
    }
}
