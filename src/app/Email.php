<?php

namespace LaravelEnso\Emails\app;

use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Teams\app\Models\Team;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Emails\Jobs\SendEmails;
use LaravelEnso\Emails\app\Enums\SendTo;
use LaravelEnso\Emails\app\Enums\Statuses;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use LaravelEnso\Emails\app\Enums\RecipientTypes;
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
   
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
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

    public function uploadAttachments($files)
    {
        collect($files)->each(function ($file) {
            $attachment = $this->attachments()->create();
            $attachment->upload($file);
        });
    }

    public function syncRecipients($sendTo, $to, $cc, $bcc, $teams)
    {
        switch ((int)$sendTo) {
            case SendTo::Users:
                $this->syncUsers($to, $cc, $bcc);
                break;
            case SendTo::Teams:
                $this->syncTeams($teams);
                break;
            case SendTo::All:
                $this->syncAll();
                break;
        }
    }

    private function syncUsers($to, $cc, $bcc)
    {
        collect([
            RecipientTypes::To => $to, RecipientTypes::Cc => $cc, RecipientTypes::Bcc => $bcc,
        ])->each(function ($ids, $type) {
            $this->users()->syncWithoutDetaching($this->buildPivot($ids, $type));
        });
    }

    private function syncTeams($teamIds)
    {
        Team::whereIn('id', $teamIds)->with('users')
            ->get()->each(function($team) {
                $this->users()->syncWithoutDetaching(
                    $this->buildPivot(
                        $team->users->pluck('id')->toArray(), RecipientTypes::To)
                    );
            });
    }

    private function syncAll()
    {
        $this->users()->sync(
            $this->buildPivot(
                User::active()->pluck('id')->toArray(),
                RecipientTypes::To
            )
        );
    }
    
    private function buildPivot($toSync, $type)
    {
        return collect($toSync)
            ->reduce(function ($pivot, $id) use ($type) {
                return $pivot->put($id, ['type' => $type]);
            }, collect());
    }

    public function send()
    {
        SendEmails::dispatch($this);
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
