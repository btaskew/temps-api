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
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($user) {
            ActiveUser::create([
                'user_id' => $user->id,
                'token' => bin2hex(random_bytes(20))
            ]);
        });

        static::deleting(function($user) {
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
}
