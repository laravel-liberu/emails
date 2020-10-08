<?php

namespace LaravelEnso\Emails\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Files\Contracts\Attachable;
use LaravelEnso\Files\Traits\HasFile;

class EmailAttachment extends Model implements Attachable
{
    use HasFile;

    //TODO refactor to belongsTo relation

    protected $optimizeImages = true;

    protected $guarded = ['id'];

    public function attachable()
    {
        $this->morphTo();
    }
}
