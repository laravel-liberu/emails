<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Enums\Priorities;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        \Log::info('Am intrat in controller. Acesta este requestul validat');
        \Log::info($request->validated());

        $email->fill($request->validated() + ['priority' => Priorities::Normal])
            ->save();

        return [
            'message' => __('The email was successfully created'),
        ];
    }
}
