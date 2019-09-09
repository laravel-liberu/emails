<?php

namespace LaravelEnso\Emails\app\Http\Controllers\Emails;

use Illuminate\Routing\Controller;
use LaravelEnso\Emails\app\Email;

class Destroy extends Controller
{
    public function __invoke(Email $email)
    {
        $email->delete();

        return [
            'message' => __('The email was successfully deleted'),
            'redirect' => 'emails.index',
        ];
    }
}
