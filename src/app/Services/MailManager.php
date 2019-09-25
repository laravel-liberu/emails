<?php

namespace LaravelEnso\Emails\app\Services;

use LaravelEnso\Emails\app\Email;
use LaravelEnso\Helpers\app\Exceptions\EnsoException;

class MailManager
{
    private $email;
    private $request;

    public function __construct(Email $email, $request)
    {
        $this->email = $email;
        $this->request = $request;
    }

    public function send()
    {
        $this->save();
        $this->email->send();
    }

    public function save()
    {
        $this->email->fill($this->request->mapped())->save();
        $this->email->syncRecipients(
            $this->request->get('sendTo'),
            $this->request->get('to'),
            $this->request->get('cc'),
            $this->request->get('bcc'),
            $this->request->get('teams'),
        );

        try {
            $this->uploadAttachments();
        } catch (EnsoException $e) {
            $this->email->update(['schedule_at' => null]);
        }
    }

    private function uploadAttachments()
    {
        $this->email->uploadAttachments($this->request->allFiles());

        return $this;
    }
}
