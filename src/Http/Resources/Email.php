<?php

namespace LaravelEnso\Emails\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\Core\Http\Resources\User;

class Email extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'priority' => $this->priority,
            'subject' => $this->subject,
            'body' => $this->body,
            'scheduleAt' => $this->schedule_at,
            'sentAt' => $this->sent_at,
            'createdBy' => new User($this->whenLoaded('createdBy')),
            'to' => $this->whenLoaded('to', $this->to->pluck('id')),
            'cc' => $this->whenLoaded('cc', $this->cc->pluck('id')),
            'bcc' => $this->whenLoaded('bcc', $this->bcc->pluck('id')),
            'sendTo' => $this->send_to,
            'teams' => $this->whenLoaded('teams', $this->teams->pluck('id')),
            'status' => $this->status,
            'files' => $this->whenLoaded('attachments', $this->attached_files),
            'errors' => null,
        ];
    }
}
