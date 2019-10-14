<?php

namespace LaravelEnso\Emails\Jobs;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use LaravelEnso\Emails\app\Email;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use LaravelEnso\Emails\app\Enums\SendTo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelEnso\Emails\Notifications\EmailNotification;

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
        $this->users()->each(function ($user) {
            $user->notify(
                (new EmailNotification($this->email))
                    ->onQueue('notifications')
            );
        });

        $this->email->update(['sent_at' => Carbon::now()]);
    }

    public function users()
    {
        return $this->email->send_to === SendTo::Teams 
            ? User::whereHas('teams', function($teams) {
                $teams->whereHas('emails', function($emails) {
                    $emails->whereId($this->email->id);
                });
            })->get()
            : $this->email->to;
    }
}
