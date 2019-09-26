<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Http\FormRequest;

class Create extends Controller
{
    public function __invoke(FormRequest $request, Email $email)
    {   
        return [
            'message' => __('The email was successfully saved!'),
        ];
    }
}
