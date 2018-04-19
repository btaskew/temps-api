<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * A Job belongs to a Staff
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * A Job has many Applications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Create a new application for this job
     *
     * @param User $user
     * @return Application
     */
    public function apply(User $user)
    {
        return $this->applications()->create([
            'worker_id' => $user->id
        ]);
    }
}
