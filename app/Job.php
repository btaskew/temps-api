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
     * A Job belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A Bob has many Applications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function apply(User $user)
    {
        return $this->applications()->create([
            'job_id' => $this->id,
            'user_id' => $user->id
        ]);
    }
}
