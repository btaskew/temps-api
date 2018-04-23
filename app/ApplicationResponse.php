<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationResponse extends Model
{
    protected $guarded = [];

    /**
     * An ApplicationResponse belongs to an Application
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}