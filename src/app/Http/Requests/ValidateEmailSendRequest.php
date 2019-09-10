<?php

namespace LaravelEnso\Emails\app\Http\Requests;

use Illuminate\Validation\Rule;
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
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'scheduleAt' => 'nullable|date_format:d-m-Y H:i',
            'priority' => Rule::in(Priorities::keys()),
        ];
    }
}
