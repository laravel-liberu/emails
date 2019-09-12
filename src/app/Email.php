<?php

namespace LaravelEnso\Emails\app;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Emails\app\Enums\Types;
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

    public function setScheduleAtAttribute($value)
    {
        $this->fillDateAttribute('schedule_at', $value, 'd-m-Y H:i');
    }

    public function setSentAtAttribute($value)
    {
        $this->fillDateAttribute('sent_at', $value);
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
}
