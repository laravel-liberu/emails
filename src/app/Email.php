<?php

namespace LaravelEnso\Emails\app;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Emails\app\Enums\Types;
use LaravelEnso\Emails\app\Enums\Statuses;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use LaravelEnso\Helpers\app\Traits\DateAttributes;
use LaravelEnso\Emails\Notifications\EmailNotification;

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
    
    public function to()
    {
        return $this->users()->whereType(Types::To);
    }

    public function cc()
    {
        return $this->users()->whereType(Types::Cc);
    }

    public function bcc()
    {
        return $this->users()->whereType(Types::Bcc);
    }   
   
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    
    public function syncRecipients($to, $cc, $bcc, $all)
    {
        if($all) {
            $this->syncAll();
            return;
        }

        $this->syncSelected($to, $cc, $bcc);
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
        $this->to->each(function ($user) {
            $user->notify(
                (new EmailNotification($this))
                    ->onQueue('notifications')
            );
        });

        $this->update(['sent_at' => Carbon::now()]);
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
        if(!$this->sent_at && !$this->schedule_at) {
            return Statuses::Draft;
        }
        return $this->sent_at ? Statuses::Sent : Statuses::Scheduled;
    }

    private function syncAll()
    {
        $this->users()->sync(
            $this->buildPivot(
                User::active()->pluck('id')->toArray(), Types::To
            )
        );
    }
    
    private function syncSelected($to, $cc, $bcc)
    {
        collect([
            Types::To => $to, Types::Cc => $cc,Types::Bcc => $bcc,
        ])->each(function ($ids, $type) {
            $this->users()->syncWithoutDetaching($this->buildPivot($ids, $type));
        });
    }

    private function buildPivot($toSync, $type)
    {
         return collect($toSync)
            ->reduce(function($pivot, $id) use ($type) {
                return $pivot->put($id, ['type' => $type]);
            }, collect());
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
