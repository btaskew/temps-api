<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * An Application belongs to a Worker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * An Application belongs to a Job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}