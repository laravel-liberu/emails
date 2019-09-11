<?php

namespace LaravelEnso\Emails\app;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Files\app\Traits\HasFile;
use LaravelEnso\Files\app\Contracts\Attachable;

class Attachment extends Model implements Attachable
{
    use HasFile;
    
    protected $optimizeImages = true;
    protected $fillable = ['name'];

    public function attachable()
    {
        $this->morphTo();
    }
}
