<?php

namespace LaravelEnso\Emails\Http\Requests;

use Carbon\Carbon;
use LaravelEnso\Emails\Enums\SendTo;
use LaravelEnso\Helpers\Traits\MapsRequestKeys;

class ValidateEmailSendRequest extends ValidateEmailRequest
{
    use MapsRequestKeys;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'teams' => 'nullable|array',
            'teams.*' => 'exists:users,id',
        ] + parent::rules();
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ((int) $this->get('sendTo') === SendTo::Users) {
                $this->checkRecipients($validator);
            }

            if ($this->filled('scheduleAt') && $this->invalidSchedule()) {
                $validator->errors()
                    ->add('scheduleAt', __('Schedule time must be after current time'));
            }
        });
    }

    private function checkRecipients($validator)
    {
        if (! $this->filled('to')) {
            $validator->errors()
                ->add('to', __('You must select at least one recipient!'));
        }

        if ($this->filled('cc') && $this->duplicate('cc', 'to', 'bcc')) {
            $validator->errors()
                ->add('cc', __('Some cc recipients are already selected in "to" or "bcc"!'));
        }

        if ($this->filled('bcc') && $this->duplicate('bcc', 'to', 'cc')) {
            $validator->errors()
                ->add('bcc', __('Some bcc recipients are already selected in "to" or "cc"!'));
        }
    }

    private function duplicate(string $toCheck, string $first, string $second)
    {
        return ! empty(array_intersect($this->get($toCheck), $this->get($first)))
            || ! empty(array_intersect($toCheck, $second));
    }

    private function invalidSchedule()
    {
        return Carbon::parse($this->get('scheduleAt'))->isBefore(Carbon::now());
    }
}
