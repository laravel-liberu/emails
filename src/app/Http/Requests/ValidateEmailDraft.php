<?php

namespace LaravelEnso\Emails\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Emails\app\Enums\Priorities;

class ValidateEmailDraft extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'all' => 'nullable|in:true,false',
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
