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
        \Log::info(gettype($this->get('all')));
        return [
            'all' => 'boolean',
            'to' => 'nullable|array',
            'cc' => 'nullable|array',
            'bcc' => 'nullable|array',
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'scheduleAt' => 'nullable|date_format:d-m-Y H:i',
            'priority' => Rule::in(Priorities::keys()),
        ];
    }

    // public function withValidator($validator)
    // {
    //     if ( $this->invalidRecipients() ) {
    //         $validator->after(function ($validator) {
    //             collect([
    //                 'all', 'to', 'cc', 'bcc'
    //             ])->each(function ($column) use ($validator) {
    //                 $validator->errors()->add(
    //                         $column,
    //                         __('ceva')
    //                     );
    //             });
    //         });
    //     }
    // }

    protected function invalidRecipients() {
        if ( $this->get('all') ) {
            if ( $this->get('to') || $this->get('cc') || $this->get('bcc') ){
                return true;
            }
        } if (! $this->get('to') ) {

        }


    }
}
