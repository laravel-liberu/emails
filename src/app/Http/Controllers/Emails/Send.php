<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use Carbon\Carbon;
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

        $delay = $request->get('scheduleAt')
            ? Carbon::createFromFormat('d-m-Y H:i', $request->get('scheduleAt'))
            : null;

        EmailJob::dispatch($email)->delay($delay);

        return [
            'message' => __('The email was successfully sent'),
        ];
    }
}
