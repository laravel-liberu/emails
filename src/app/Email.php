<?php

namespace LaravelEnso\Emails\app;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Teams\app\Models\Team;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Emails\Jobs\SendEmails;
use LaravelEnso\Emails\app\Enums\Statuses;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use LaravelEnso\Emails\app\Enums\RecipientTypes;
use LaravelEnso\Helpers\app\Traits\DateAttributes;

class Email extends Model
{
    use DateAttributes, CreatedBy;

    protected $fillable = [
        'subject', 'body', 'priority', 'send_to', 'schedule_at',
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
    
    public function to()
    {
        return $this->users()->whereType(RecipientTypes::To);
    }

    public function cc()
    {
        return $this->users()->whereType(RecipientTypes::Cc);
    }

    public function bcc()
    {
        return $this->users()->whereType(RecipientTypes::Bcc);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
   
    public function attachments()
    {
        return $this->morphMany(EmailAttachment::class, 'attachable');
    }

    public function uploadAttachments($files)
    {
        collect($files)->each(function ($file) {
            $attachment = $this->attachments()->create();
            $attachment->upload($file);
        });
    }

    public function send()
    {
        SendEmails::dispatch($this);
    }

    public function setScheduleAtAttribute($value)
    {
        $this->fillDateAttribute('schedule_at', $value, 'd-m-Y H:i');
    }

    public function setSentAtAttribute($value)
    {
        $this->fillDateAttribute('sent_at', $value);
    }

    public function getStatusAttribute()
    {
        if (!$this->sent_at && !$this->schedule_at) {
            return Statuses::Draft;
        }

        return $this->sent_at ? Statuses::Sent : Statuses::Scheduled;
    }

    public function getAttachedFilesAttribute()
    {
        return $this->attachments->map(function ($attachment) {
            return ['name' => $attachment->file->original_name];
        });
    }

    public function delete()
    {
        DB::beginTransaction();
        $this->to()->detach();
        $this->bcc()->detach();
        $this->cc()->detach();
        $this->attachments->each->delete();
        DB::commit();
        parent::delete();
    }
}
