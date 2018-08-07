<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return BelongsTo
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * An Education belongs to many Applications
     *
     * @return BelongsToMany
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }
}
