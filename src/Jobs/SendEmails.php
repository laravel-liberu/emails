<?php

namespace LaravelLiberu\Emails\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelLiberu\Core\Models\User;
use LaravelLiberu\Emails\Enums\SendTo;
use LaravelLiberu\Emails\Models\Email;
use LaravelLiberu\Emails\Notifications\EmailNotification;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue;
    public $timeout;

    protected $email;
    protected $users;

    public function __construct(Email $email)
    {
        $this->queue = 'heavy';
        $this->timeout = 100;
        $this->email = $email;
    }

    public function handle()
    {
        $this->users()->each->notify(
            (new EmailNotification($this->email))
                ->onQueue('notifications')
        );

        $this->email->update(['sent_at' => Carbon::now()]);
    }

    public function users()
    {
        return $this->email->send_to === SendTo::Teams
            ? User::whereHas('teams', fn ($teams) => $teams
                ->whereHas('emails', fn ($emails) => $emails
                    ->whereId($this->email->id)))
            ->get()
            : $this->email->to;
    }
}
