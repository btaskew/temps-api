<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationResponse extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($response) {
            if ($response->type == 'approved') {
                $job = $response->application->job;
                $job->update([
                    'approved_application_id' => $response->application->id,
                    'open_vacancies' => $job->open_vacancies - 1
                ]);
            }
        });
    }

    /**
     * An ApplicationResponse belongs to an Application
     *
     * @return BelongsTo
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
