<?php

namespace LaravelEnso\Emails\app;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Files\App\Contracts\Attachable;
use LaravelEnso\Files\App\Traits\HasFile;

class EmailAttachment extends Model implements Attachable
{
    use HasFile;

    protected $optimizeImages = true;

    protected $fillable = ['name'];

    public function attachable()
    {
        $this->morphTo();
    }
}
