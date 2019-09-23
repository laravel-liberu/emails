<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailDraft;

class Draft extends Controller
{
    public function __invoke(ValidateEmailDraft $request, Email $email)
    {
        $email->fill($request->mapped())->save();
        $email->syncRecipients(
            $request->get('to'), 
            $request->get('cc'),
            $request->get('bcc'), 
            $request->get('all') === 'true'
        );

        $email->uploadAttachments($request->allFiles());


        return [
            'message' => __('The email was successfully saved as draft'),
        ];
    }
}
