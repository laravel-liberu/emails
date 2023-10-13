<?php

namespace LaravelLiberu\Emails\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelLiberu\Emails\Enums\Priorities;
use LaravelLiberu\Emails\Enums\SendTo;
use LaravelLiberu\Helpers\Traits\MapsRequestKeys;

class ValidateEmail extends FormRequest
{
    use MapsRequestKeys;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sendTo' => 'in:'.SendTo::keys()->implode(','),
            'to' => 'nullable|array',
            'to.*' => 'exists:users,id',
            'cc' => 'nullable|array',
            'cc.*' => 'exists:users,id',
            'bcc' => 'nullable|array',
            'bcc.*' => 'exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'scheduleAt' => 'nullable|date_format:Y-m-d H:i',
            'priority' => Rule::in(Priorities::keys()),
        ];
    }
}
