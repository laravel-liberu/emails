<?php

namespace LaravelEnso\Emails\Notifications;

use Illuminate\Bus\Queueable;
use LaravelEnso\Emails\app\Email;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class EmailNotification extends Notification
{
    use Queueable;

    protected $sender;
    protected $cc;
    protected $bcc;
    protected $subject;
    protected $body;
    protected $attachments;

    public function __construct(Email $email, array $files)
    {
        $this->sender = $email->createdBy;
        $this->cc = $email->cc()->pluck('email');
        $this->bcc = $email->bcc()->pluck('email');
        $this->subject = $email->subject;
        $this->body = $email->body;
        $this->attachments = $email->attachments()->with('file')->get();
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'level' => 'info',
            'title' => __('General Notification'),
            'icon' => 'comment',
            'body' => __("You've received a new email!"),
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'body' => __("You've received a new email!"),
            'icon' => 'comment',
        ];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->from($this->sender->email, $this->sender->person->name)
            ->cc($this->cc)
            ->bcc($this->bcc)
            ->subject($this->subject)
            ->line($this->body)
            ->line('Thank you for using our application!');

        collect($this->attachments)->each(function ($attachment) use ($message) {
            $message->attach(
                storage_path('app/files/' . $attachment->file->saved_name), 
                ['as' => $attachment->file->original_name]
            );
        });

        return $message;
    }
}
