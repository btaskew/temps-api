<?php

namespace App\Filters;

class JobFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['tags', 'minDuration', 'maxDuration', 'minRate', 'maxRate', 'owner'];

    /**
     * Show jobs which have a duration more than the given value
     *
     * @param string $duration
     */
    protected function minDuration(string $duration): void
    {
        $this->builder->where('duration', '>=', $duration);
    }

    /**
     * Show jobs which have a duration less than the given value
     *
     * @param string $duration
     */
    protected function maxDuration(string $duration): void
    {
        $this->builder->where('duration', '<=', $duration);
    }

    /**
     * Show jobs which have a rate more than the given value
     *
     * @param string $rate
     */
    protected function minRate(string $rate): void
    {
        $this->builder->where('rate', '>=', $rate);
    }

    /**
     * Show jobs which have a rate less than the given value
     *
     * @param string $rate
     */
    protected function maxRate(string $rate): void
    {
        $this->builder->where('rate', '<=', $rate);
    }

    /**
     * Append to query for each tag
     *
     * @param string $tags
     */
    protected function tags(string $tags): void
    {
        $this->builder->join('tags', 'jobs.id', '=', 'tags.job_id');

        $tagsArray = explode(',', $tags);
        $firstTag = true;

        foreach ($tagsArray as $tag) {
            if ($firstTag) {
                $this->builder->where('tags.tag', '=', filter_var($tag, FILTER_SANITIZE_STRING));
                $firstTag = false;
                continue;
            }

            $this->builder->orWhere('tags.tag', '=', filter_var($tag, FILTER_SANITIZE_STRING));
        }
    }

    /**
     * Only show jobs owned by the provided user
     *
     * @param string $id
     */
    protected function owner(string $id): void
    {
        $this->builder->where('staff_id', '=', $id);
    }
}
