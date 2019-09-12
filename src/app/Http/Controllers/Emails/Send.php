<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\Jobs\EmailJob;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;

class Send extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        $email->fill($request->mapped())->save();
        $email->syncRecipients(
            $request->get('to'), $request->get('cc'),
            $request->get('bcc'), $request->get('all') === 'true'
        );
        $email->uploadAttachments($request->allFiles());
        EmailJob::dispatch($email);

        return [
            'message' => __('The email was successfully sent'),
        ];
    }
}
