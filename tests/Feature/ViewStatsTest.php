<?php

class ViewStatsTest extends TestCase
{
    /** @test */
    public function anyone_can_view_the_website_stats()
    {
        create('App\Job', [], 4);
        create('App\Worker', [], 3);
        // This will create 6 jobs and 6 workers
        create('App\ApplicationResponse', ['type' => 'approved'], 6);

        $this->get('/stats')
            ->seeJson([
                'jobs_count' => 10,
                'workers_count' => 9,
                'approved_count' => 6
            ]);
    }
}