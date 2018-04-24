<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /**
     * The table used by the model
     *
     * @var string
     */
    protected $table = 'experience';

    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * An Experience belongs to a Worker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * An Experience belongs to many Applications
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications()
    {
        return $this->belongsToMany(Application::class);
    }
}