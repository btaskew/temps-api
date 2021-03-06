<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'id', 'staff'
    ];

    /**
     * Values to include when returning a user
     *
     * @var array
     */
    protected $appends = [
        'type'
    ];

    /**
     * A User has a Staff
     *
     * @return HasOne
     */
    public function staff(): HasOne
    {
        return $this->hasOne(Staff::class);
    }

    /**
     * A User has a Worker
     *
     * @return HasOne
     */
    public function worker(): HasOne
    {
        return $this->hasOne(Worker::class);
    }

    /**
     * Creates and assigns a login token for the user
     *
     * @return $this
     */
    public function login()
    {
        $this->update(['token' => bin2hex(random_bytes(20))]);

        return $this;
    }

    /**
     * Returns the user's type
     *
     * @return string
     */
    protected function getTypeAttribute(): string
    {
        if ($this->staff()->exists()) {
            return 'staff';
        }

        return 'worker';
    }
}
