<?php

namespace LaravelEnso\Emails\app\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use LaravelEnso\Emails\app\Enums\SendTo;
use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Helpers\app\Traits\MapsRequestKeys;

class ValidateEmailSendRequest extends FormRequest
{
    use MapsRequestKeys;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sendTo' => 'in:' . SendTo::keys()->implode(','),
            'to' => 'nullable|array',
            'to.*' => 'exists:users,id',
            'cc' => 'nullable|array',
            'cc.*' => 'exists:users,id',
            'bcc' => 'nullable|array',
            'bcc.*' => 'exists:users,id',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'scheduleAt' => 'nullable|date_format:d-m-Y H:i',
            'priority' => Rule::in(Priorities::keys()),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ((int)$this->get('sendTo') === SendTo::Users) {
                $this->checkRecipients(
                    $validator,
                    $this->get('to'),
                    $this->get('cc'),
                    $this->get('bcc')
                );
            }

            if ($this->invalidScheduleTime()) {
                $validator->errors()
                    ->add('scheduleAt', __('Schedule time must be after current time'));
            }
        });
    }

    private function checkRecipients($validator, $to, $cc, $bcc)
    {
        if (empty($to)) {
            $validator->errors()
                ->add('to', __('You must select at least one recipient!'));
            return;
        }

        if (! empty($cc) && $this->intersectsAtLeastOne($cc, $to, $bcc ?? [])) {
            $validator->errors()
                ->add('cc', __('Some cc recipients are already selected in "to" or "bcc"!'));
            return;
        }

        if (! empty($bcc) && $this->intersectsAtLeastOne($bcc, $to, $cc ?? [])) {
            $validator->errors()
                ->add('bcc', __('Some bcc recipients are already selected in "to" or "cc"!'));
        }
    }

    private function intersectsAtLeastOne($toCheck, $array1, $array2)
    {
        return ! empty(array_intersect($toCheck, $array1))
            || ! empty(array_intersect($toCheck, $array2));
    }

    private function invalidScheduleTime()
    {
        return $this->get('scheduleAt')
            ? Carbon::createFromFormat(
                'd-m-Y H:i', $this->get('scheduleAt')
            )->isBefore(Carbon::now())
            : false;
    }
}
