<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Staff extends Model
{
    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * A Staff has a User
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }

    /**
     * A User has many Jobs
     *
     * @return HasMany
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
