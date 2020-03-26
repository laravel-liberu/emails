<?php

namespace LaravelEnso\Emails\App\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\App\Email;
use LaravelEnso\Emails\App\Http\Requests\ValidateEmailRequest;

class Update extends Controller
{
    public function __invoke(ValidateEmailRequest $request, Email $email)
    {
        $email->email->update($request->mapped());

        $email->syncRecipients()
            ->syncAttachments();

        return [
            'message' => __('The email was successfully updated!'),
        ];
    }
}
