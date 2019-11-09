<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Email;

class Create extends Controller
{
    public function __invoke(FormRequest $request, Email $email)
    {
        return [
            'message' => __('The email was successfully saved!'),
        ];
    }
}
