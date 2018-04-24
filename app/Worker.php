<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * A Worker has a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id');
    }

    /**
     * A Worker has many Applications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * A Worker has many Experiences
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experience()
    {
        return $this->hasMany(Experience::class);
    }
}