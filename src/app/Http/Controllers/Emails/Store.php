<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use LaravelEnso\Emails\app\Email;
use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Http\Requests\ValidateEmailSendRequest;

class Store extends Controller
{
    public function __invoke(ValidateEmailSendRequest $request, Email $email)
    {
        \Log::info($request->mapped());
        $email->fill($request->mapped())->save();

        return [
            'message' => __('The email was successfully created'),
        ];
    }
}
