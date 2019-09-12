<?php

namespace LaravelEnso\Emails\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use LaravelEnso\Emails\app\Email;
use LaravelEnso\Emails\Notifications\EmailNotification;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue;
    public $timeout;

    protected $email;
    protected $files;

    public function __construct( Email $email, array $files )
    {
        $this->queue = 'heavy';
        $this->timeout = 100;

        $this->email = $email;        
        $this->files = $files;        
    }

    public function handle()
    {
        $delay = 0;

        $this->email->to
            ->chunk(5)
            ->each(function ($user) use ($delay) {
                $user->each->notify(
                    (new EmailNotification(
                        $this->email,
                        $this->files
                    ))->onQueue('notifications')
                    ->delay($delay)
                );

                $delay++;
            });

    }
}
