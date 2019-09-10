<?php

namespace LaravelEnso\Emails\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEmailSendRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        \Log::info('Am intrat in validator. Acesta este tot requestul');
        \Log::info(gettype($this->get('schedule_at')));

        return [
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'schedule_at' => 'nullable|string',
        ];
    }
}
