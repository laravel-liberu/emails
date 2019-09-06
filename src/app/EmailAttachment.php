<?php

namespace LaravelEnso\Emails\app;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Files\app\Traits\HasFile;

class EmailAttachment extends Model
{
    use HasFile;

    protected $fillable = [
        'email_id'
    ];
}
