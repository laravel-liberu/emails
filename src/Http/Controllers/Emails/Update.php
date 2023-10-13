<?php

namespace LaravelLiberu\Emails\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelLiberu\Emails\Http\Requests\ValidateEmail;
use LaravelLiberu\Emails\Models\Email;

class Update extends Controller
{
    public function __invoke(ValidateEmail $request, Email $email)
    {
        $email->email->update($request->mapped());

        $email->syncRecipients()
            ->syncAttachments();

        return [
            'message' => __('The email was successfully updated!'),
        ];
    }
}
