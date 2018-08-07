<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return BelongsTo
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * An Experience belongs to many Applications
     *
     * @return BelongsToMany
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }
}
