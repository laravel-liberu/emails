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
        \Log::info($this->all());
        return [
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'schedule_at' => 'nullable|date_format:"d-m-Y H:i:s"',
        ];
    }
}
