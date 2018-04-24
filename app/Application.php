<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

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
     * An Application belongs to many Experiences
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function experience()
    {
        return $this->belongsToMany(Experience::class);
    }

    /**
     * Determines if application has been approved
     *
     * @return bool
     */
    public function isApproved()
    {
        if (!$this->hasResponse()) {
            return false;
        }

        return $this->response->type == 'approved';
    }

    /**
     * Determines if application has a response
     *
     * @return bool
     */
    public function hasResponse()
    {
        return !is_null($this->response);
    }

    /**
     * Save relation to given experience for application
     *
     * @param array $experienceIds
     */
    public function saveExperience(array $experienceIds)
    {
        foreach ($experienceIds as $id) {
            $experience = Experience::findOrFail($id);

            if ($experience->worker_id != Auth::user()->worker->id) {
                throw new UnauthorizedException('Experience not owned by user');
            }

            $this->experience()->attach($id);
        }
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
            $this->job->update([
                'approved_application_id' => $this->id,
                'open_vacancies' => $this->job->open_vacancies - 1
            ]);
        }

        if ($response['reject_all']) {
            $this->job->rejectOpenApplications();
        }
    }
}