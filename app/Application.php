<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class Application extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Relations to include when returning an application
     *
     * @var array
     */
    protected $with = ['response'];

    /**
     * An Application belongs to a Worker
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    /**
     * An Application belongs to a Job
     *
     * @return BelongsTo
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * An Application has an ApplicationResponse
     *
     * @return HasOne
     */
    public function response(): HasOne
    {
        return $this->hasOne(ApplicationResponse::class);
    }

    /**
     * An Application belongs to many Educations
     *
     * @return BelongsToMany
     */
    public function education(): BelongsToMany
    {
        return $this->belongsToMany(Education::class);
    }

    /**
     * An Application belongs to many Experiences
     *
     * @return BelongsToMany
     */
    public function experience(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class);
    }

    /**
     * Determines if application has been approved
     *
     * @return bool
     */
    public function isApproved(): bool
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
    public function hasResponse(): bool
    {
        return !is_null($this->response);
    }

    /**
     * Save relation to given experience for application
     *
     * @param array $experienceIds
     */
    public function saveExperience(array $experienceIds): void
    {
        foreach ($experienceIds as $id) {
            $this->validateExperience($id);

            $this->experience()->attach($id);
        }
    }

    /**
     * Create a response for the application
     *
     * @param array $response
     */
    public function respond(array $response): void
    {
        $this->response()->create([
            'type' => $response['type'],
            'comment' => $response['comment']
        ]);

        if ($response['reject_all']) {
            $this->job->rejectOpenApplications();
        }
    }

    /**
     * Validates whether the given experience exists and is owned by the user
     *
     * @param $id
     */
    private function validateExperience($id): void
    {
        $experience = Experience::findOrFail($id);

        if ($experience->worker_id != Auth::user()->worker->id) {
            throw new UnauthorizedException('Experience not owned by user');
        }
    }
}
