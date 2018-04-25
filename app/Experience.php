<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    /**
     * Disable timestamps for the model
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table used by the model
     *
     * @var string
     */
    protected $table = 'experience';

    /**
     * @var array
     */
    protected $guarded = [];

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
