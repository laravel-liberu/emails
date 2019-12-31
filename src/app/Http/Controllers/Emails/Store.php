<?php

namespace LaravelEnso\Emails\App\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\App\Email;
use LaravelEnso\Emails\App\Http\Requests\ValidateEmailRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailRequest $request, Email $email)
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
