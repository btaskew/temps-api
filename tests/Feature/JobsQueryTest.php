<?php

class JobsQueryTest extends TestCase
{
    /** @test */
    public function can_query_for_all_jobs()
    {
        $jobs = factory('App\Job', 3)->create();

        $this->get('/jobs')
            ->seeJsonContains([
                'id' => $jobs[0]->id,
                'title' => $jobs[1]->title,
                'description' => $jobs[2]->description
            ]);
    }

    /** @test */
    public function can_query_for_a_single_job()
    {
        $job = factory('App\Job')->create();
        $otherJob = factory('App\Job')->create();

        $this->get("/jobs/$job->id")
            ->seeJsonContains([
                'title' => $job->title
            ])->dontSeeJson([
                'title' => $otherJob->title
            ]);
    }
}
