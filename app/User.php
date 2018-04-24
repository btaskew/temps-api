<?php

namespace App;

use Illuminate\Auth\Authenticatable;
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
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->activeUser->delete();
        });
    }

    /**
     * A User has one ActiveUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activeUser()
    {
        return $this->hasOne(ActiveUser::class);
    }

    /**
     * A User has a Staff
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    /**
     * A User has a Worker
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function worker()
    {
        return $this->hasOne(Worker::class);
    }

    /**
     * Creates an ActiveUser instance for the current user
     *
     * @return ActiveUser
     */
    public function setActive()
    {
        return $this->activeUser()->create([
            'token' => bin2hex(random_bytes(20))
        ]);
    }
}
