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
    public function owner()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
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

    /**
     * Determines if application has been approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->id == $this->job->approved_application_id;
    }
}