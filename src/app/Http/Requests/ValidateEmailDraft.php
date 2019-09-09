<?php

namespace LaravelEnso\Emails\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEmailDraft extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
