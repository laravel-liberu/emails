<?php

namespace LaravelEnso\Emails\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use LaravelEnso\Emails\app\Email;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelEnso\Emails\Notifications\EmailNotification;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue;
    public $timeout;

    protected $email;

    public function __construct(Email $email)
    {
        $this->queue = 'heavy';
        $this->timeout = 100;

        $this->email = $email;      
    }

    public function handle()
    {
        $delay = 0;
        $this->email->to->each(function ($user) use (&$delay) {
                $user->each->notify(
                    (new EmailNotification($this->email))
                        ->onQueue('notifications')
                        ->delay($delay)
                );
                $delay++;
            });
        $this->email->update(['sent_at' => Carbon::now()]);
    }
}
