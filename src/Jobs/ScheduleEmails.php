<?php

namespace LaravelLiberu\Emails\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LaravelLiberu\Emails\Models\Email;

class ScheduleEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $queue;
    public $timeout;

    public function __construct()
    {
        $this->queue = 'heavy';
        $this->timeout = 100;
    }

    public function handle()
    {
        Email::whereNull('sent_at')
            ->whereBetween('schedule_at', [Carbon::now(), Carbon::now()->addMinutes(3)])
            ->get()->each->send();
    }
}
