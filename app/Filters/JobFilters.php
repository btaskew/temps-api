<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class JobFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['tags', 'minDuration', 'maxDuration', 'minRate', 'maxRate'];

    /**
     * Show jobs which have a duration more than the given value
     *
     * @param string $duration
     */
    protected function minDuration(string $duration)
    {
        $this->builder->where('duration', '>=', $duration);
    }

    /**
     * Show jobs which have a duration less than the given value
     *
     * @param string $duration
     */
    protected function maxDuration(string $duration)
    {
        $this->builder->where('duration', '<=', $duration);
    }

    /**
     * Show jobs which have a rate more than the given value
     *
     * @param string $rate
     */
    protected function minRate(string $rate)
    {
        $this->builder->where('rate', '>=', $rate);
    }

    /**
     * Show jobs which have a rate less than the given value
     *
     * @param string $rate
     */
    protected function maxRate(string $rate)
    {
        $this->builder->where('rate', '<=', $rate);
    }

    /**
     * Append to query for each tag
     *
     * @param string $tags
     * @return Builder
     */
    protected function tags(string $tags)
    {
        $this->builder->join('tags', 'jobs.id', '=', 'tags.job_id');

        $tagsArray = explode(',', $tags);

        foreach ($tagsArray as $tag) {
            $this->builder->orWhere('tags.tag', '=', filter_var($tag, FILTER_SANITIZE_STRING));
        }
    }

}