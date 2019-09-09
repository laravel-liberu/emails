<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        $email->fill($request->validated() + ['priority' => Priorities::Normal])
            ->save();

        return [
            'message' => __('The email was successfully created'),
        ];
    }
}
