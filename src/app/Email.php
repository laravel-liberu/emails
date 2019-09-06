<?php

namespace LaravelEnso\Emails\app;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Traits\DateAttributes;

class Email extends Model
{
    use DateAttributes;

    protected $fillable = [
        'subject', 'body', 'priority', 'schedule_at',
        'sent_at', 'created_by',
    ];

    protected $dates = ['schedule_at', 'sent_at'];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'email_recipients',
            'email_id',
            'recipient_id'
        )->withPivot('type');
    }

    public function setScheduleAt($value)
    {
        $this->fillDateAttribute('schedule_at', $value);
    }

    public function setSentAt($value)
    {
        $this->fillDateAttribute('sent_at', $value);
    }
}
