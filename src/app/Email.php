<?php

namespace LaravelEnso\Emails\app;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use LaravelEnso\Helpers\app\Traits\DateAttributes;

class Email extends Model
{
    use DateAttributes, CreatedBy;

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

    public function setScheduleAtAttribute($value)
    {
        $this->fillDateAttribute('schedule_at', $value, 'd-m-Y H:i');
    }

    public function setSentAtAttribute($value)
    {
        $this->fillDateAttribute('sent_at', $value);
    }
}
