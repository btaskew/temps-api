<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
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
     * A User belongs to a Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Creates an ActiveUser instance for the current user
     */
    public function setActive()
    {
        ActiveUser::create([
            'user_id' => $this->id,
            'token' => bin2hex(random_bytes(20))
        ]);
    }
}
