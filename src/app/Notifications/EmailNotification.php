<?php

namespace LaravelEnso\Emails\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use LaravelEnso\Emails\app\Email;

class EmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
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
        return $this->attachFiles($this->createMessage());
    }

    private function createMessage()
    {
        return (new MailMessage())->from(
                $this->email->createdBy->email,
                $this->email->createdBy->name
            )->priority($this->email->priority)
            ->cc($this->email->cc()->pluck('email'))
            ->bcc($this->email->bcc()->pluck('email'))
            ->subject($this->email->subject)
            ->line($this->email->body)
            ->line('Thank you for using our application!');
    }

    private function attachFiles($message)
    {
        collect($this->email->attachments()->with('file')->get())
            ->each(function ($attachment) use ($message) {
                $message->attach(
                    storage_path('app/files/'.$attachment->file->saved_name),
                    ['as' => $attachment->file->original_name]
                );
            });

        return $message;
    }
}
