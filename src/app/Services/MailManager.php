<?php

namespace LaravelEnso\Emails\app\Services;

use App\User;
use LaravelEnso\Emails\app\Email;
use LaravelEnso\Emails\app\Enums\RecipientTypes;
use LaravelEnso\Emails\app\Enums\SendTo;
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

    public function update()
    {
        $this->email->update($this->request->mapped());
        $this->syncRecipients()->syncAttachments();
    }

    public function send()
    {
        $this->save();
        $this->email->send();
    }

    public function save()
    {
        $this->email->fill($this->request->mapped())->save();
        $this->syncRecipients()->syncAttachments();
    }

    private function syncRecipients()
    {
        switch ((int) $this->request->get('sendTo')) {
            case SendTo::Users:
                $this->email->users()->sync($this->users());
                break;
            case SendTo::Teams:
                $this->email->teams()->sync($this->request->get('teams'));
                break;
            case SendTo::All:
                $this->email->users()->sync($this->all());
                break;
            default:
                throw new EnsoException('Invalid send to option!');
        }

        return $this;
    }

    private function users()
    {
        return collect([
            RecipientTypes::To => $this->request->get('to'),
            RecipientTypes::Cc => $this->request->get('cc'),
            RecipientTypes::Bcc => $this->request->get('bcc'),
        ])->mapWithKeys(function ($ids, $type) {
            return $this->buildPivot($ids, $type);
        })->filter();
    }

    private function all()
    {
        return $this->buildPivot(
            User::pluck('id')->toArray(),
            RecipientTypes::To,
        );
    }

    private function buildPivot($toSync, $type)
    {
        return collect($toSync)
            ->mapWithKeys(function ($id) use ($type) {
                return [$id => ['type' => $type]];
            });
    }

    private function syncAttachments()
    {
        \Log::info($this->request->allFiles());
        try {
            $this->email->attachments->each->delete();
            $this->email->uploadAttachments(
                $this->request->allFiles()
            );
        } catch (EnsoException $e) {
            $this->email->update(['schedule_at' => null]);
            throw new EnsoException('Upload error!');
        }

        return $this;
    }
}
