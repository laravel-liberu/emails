<?php

namespace LaravelEnso\Emails\app\Services;

use LaravelEnso\Emails\app\Email;
use LaravelEnso\Emails\Jobs\EmailJob;
use LaravelEnso\Helpers\app\Exceptions\EnsoException;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;

class MailManager
{
    private $email;
    private $request;

    public function __construct(ValidateEmailSendRequest $request, Email $email)
    {
        $this->email = $email;
        $this->request = $request;
    }

    public function handle()
    {
        try {
            $this->saveMail()
                ->uploadAttachments()
                ->sendEmails();
        } catch (EnsoException $e) {
            $this->email->update(['schedule_at' => null]);
        }
    }

    private function saveMail()
    {
        $this->email->fill($this->request->mapped())->save();
        $this->email->syncRecipients(
            $this->request->get('to'), 
            $this->request->get('cc'),
            $this->request->get('bcc'), 
            $this->request->get('all') === 'true'
        );

        return $this;
    }

    private function uploadAttachments()
    {
        $this->email->uploadAttachments($this->request->allFiles());

        return $this;
    }

    private function sendEmails()
    {
        if(!$this->email->schedule_at) {
            EmailJob::dispatch($this->email);
        }

        return $this;
    }
}
