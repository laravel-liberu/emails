<?php

namespace LaravelEnso\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\Http\Requests\ValidateEmailRequest;
use LaravelEnso\Emails\Models\Email;

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
