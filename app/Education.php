<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * An Education belongs to a Worker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * An Education belongs to many Applications
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications()
    {
        return $this->belongsToMany(Application::class);
    }
}
