<?php

namespace LaravelEnso\Emails\app\Http\Requests;

use Illuminate\Validation\Rule;
use LaravelEnso\Emails\app\Enums\SendTo;
use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Helpers\app\Traits\MapsRequestKeys;

class ValidateEmailRequest extends FormRequest
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
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'scheduleAt' => 'nullable|date_format:d-m-Y H:i',
            'priority' => Rule::in(Priorities::keys()),
        ];
    }
}
