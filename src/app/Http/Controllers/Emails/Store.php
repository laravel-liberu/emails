<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        $email->fill($request->mapped())->save();
        $email->syncRecipients(
            $request->get('to'), $request->get('cc'),
            $request->get('bcc'), $request->get('all') === 'true'
        );

        collect($request->allFiles())->each(function($file) use($email) {
            $attachment = $email->attachments()->create();
            $attachment->upload($file);
        });

        //TODO status, browser destept

        return [
            'message' => __('The email was successfully created'),
        ];
    }
}
