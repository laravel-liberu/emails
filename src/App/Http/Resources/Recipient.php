<?php

namespace LaravelEnso\Emails\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Recipient extends JsonResource
{
    public function toArray($request)
    {
        return ['id' => $this->id];
    }
}
