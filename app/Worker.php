<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Worker extends Model
{
    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'website'
    ];

    /**
     * Relations to include when returning a worker
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * A Worker has a User
     *
     * @return hasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }

    /**
     * A Worker has many Applications
     *
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * A Worker has many Educations
     *
     * @return HasMany
     */
    public function education(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    /**
     * A Worker has many Experiences
     *
     * @return HasMany
     */
    public function experience(): HasMany
    {
        return $this->hasMany(Experience::class);
    }
}
