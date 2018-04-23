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
     * An Application has an ApplicationResponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function response()
    {
        return $this->hasOne(ApplicationResponse::class);
    }

    /**
     * Determines if application has been approved
     *
     * @return bool
     */
    public function isApproved()
    {
        if (!$this->response) {
            return false;
        }

        return $this->response->type == 'approved';
    }

    /**
     * Create a response for the application
     *
     * @param array $response
     */
    public function respond(array $response)
    {
        $this->response()->create([
            'type' => $response['type'],
            'comment' => $response['comment']
        ]);

        if ($response['type'] == 'approved') {
            $this->job->update(['approved_application_id' => $this->id]);
        }
    }
}