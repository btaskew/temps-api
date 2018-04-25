<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * An ActiveUser belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
