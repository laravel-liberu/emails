<?php

namespace LaravelEnso\Emails\app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Emails\App\Enums\RecipientTypes;
use LaravelEnso\Emails\App\Enums\SendTo;
use LaravelEnso\Emails\App\Enums\Statuses;
use LaravelEnso\Emails\Jobs\SendEmails;
use LaravelEnso\Helpers\App\Exceptions\EnsoException;
use LaravelEnso\Tables\App\Traits\TableCache;
use LaravelEnso\Teams\App\Models\Team;
use LaravelEnso\TrackWho\App\Traits\CreatedBy;

class Email extends Model
{
    use CreatedBy, TableCache;

    protected $fillable = [
        'subject', 'body', 'priority', 'send_to', 'schedule_at', 'sent_at', 'created_by',
    ];

    protected $dates = ['schedule_at', 'sent_at'];

    public function users()
    {
        return $this->belongsToMany(
            User::class, 'email_recipients', 'email_id', 'recipient_id'
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
        (new Collection($files))->each(fn ($file) => $this->attachments()
            ->create()->upload($file));
    }

    public function send()
    {
        SendEmails::dispatch($this);
    }

    public function getStatusAttribute()
    {
        if ($this->sent_at) {
            return Statuses::Sent;
        }

        return $this->schedule_at ? Statuses::Scheduled : Statuses::Draft;
    }

    public function getAttachedFilesAttribute()
    {
        return $this->attachments
            ->map(fn ($attachment) => ['name' => $attachment->file->original_name]);
    }

    public function delete()
    {
        DB::transaction(function () {
            $this->to()->detach();
            $this->bcc()->detach();
            $this->cc()->detach();
            $this->attachments->each->delete();
        });

        parent::delete();
    }

    public function syncRecipients()
    {
        switch ((int) $this->request->get('sendTo')) {
            case SendTo::Users:
                $this->email->users()->sync($this->users());
                break;
            case SendTo::Teams:
                $this->email->teams()->sync($this->request->get('teams'));
                break;
            case SendTo::All:
                $this->email->users()->sync($this->all());
                break;
            default:
                throw new EnsoException('Invalid send to option!');
        }

        return $this;
    }

    public function syncAttachments()
    {
        try {
            $this->email->attachments->each->delete();
            $this->email->uploadAttachments(
                $this->request->allFiles()
            );
        } catch (EnsoException $exception) {
            $this->email->update(['schedule_at' => null]);
            throw new EnsoException('Upload error!');
        }

        return $this;
    }
}
