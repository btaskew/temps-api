<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Job extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * A Job belongs to a Staff
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * A Job has many Applications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * A Job has many Tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * Append to query for each tag
     *
     * @param Builder $query
     * @param string  $tags
     * @return Builder|static
     */
    public function scopeFilterByTags(Builder $query, string $tags)
    {
        $query->join('tags', 'jobs.id', '=', 'tags.job_id');

        $tagsArray = explode(',', $tags);

        foreach ($tagsArray as $tag) {
            $query->orWhere('tags.tag', '=', filter_var($tag, FILTER_SANITIZE_STRING));
        }

        return $query;
    }

    /**
     * Only show jobs that haven't passed their closing date
     *
     * @param Builder $query
     */
    public function scopeOpen(Builder $query)
    {
        $query->where('closing_date', '>', Carbon::now());
    }

    /**
     * Only show jobs that have open vacancies
     *
     * @param Builder $query
     */
    public function scopeWithVacancies(Builder $query)
    {
        $query->where('open_vacancies', '>', 0);
    }

    /**
     * Determines if the job is open for applications
     *
     * @return bool
     */
    public function openForApplications()
    {
        return $this->closing_date > Carbon::now() && $this->open_vacancies > 0;
    }

    /**
     * Create a new application for this job
     *
     * @param Worker $worker
     * @return Application
     */
    public function apply(Worker $worker)
    {
        return $this->applications()->create([
            'worker_id' => $worker->id
        ]);
    }

    /**
     * Save associated tags
     *
     * @param array $tags
     */
    public function saveTags(array $tags)
    {
        foreach ($tags as $tag) {
            $this->tags()->create(['tag' => $tag]);
        }
    }

    /**
     * Rejects all applications for the job that don't have a response
     */
    public function rejectOpenApplications()
    {
        foreach ($this->applications as $application) {
            if (!$application->hasResponse()) {
                $application->response()->create([
                    'type' => 'rejected',
                    'comment' => 'Sorry your application has been rejected.'
                ]);
            }
        }
    }
}
