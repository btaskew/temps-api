<?php

class ViewJobsTest extends TestCase
{
    /** @test */
    public function can_query_for_all_jobs()
    {
        $jobs = create('App\Job', [], 3);

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
        $job = create('App\Job');
        $otherJob = create('App\Job');

        $this->get("/jobs/$job->id")
            ->seeJsonContains([
                'title' => $job->title
            ])->dontSeeJson([
                'title' => $otherJob->title
            ]);
    }

    /** @test */
    public function can_query_for_jobs_by_single_tag()
    {
        $job = create('App\Job');
        $job->saveTags(['foo', 'bar']);
        $jobWithNoTags = create('App\Job');

        $this->get('/jobs?tags=foo')
            ->seeJsonContains(['title' => $job->title])
            ->dontSeeJson(['title' => $jobWithNoTags->title]);
    }

    /** @test */
    public function can_query_for_jobs_by_multiple_tags()
    {
        $job = create('App\Job');
        $job->saveTags(['foo']);
        $secondJob = create('App\Job');
        $secondJob->saveTags(['bar']);
        $jobWithNoTags = create('App\Job');

        $this->get('/jobs?tags=foo,bar')
            ->seeJsonContains(['title' => $job->title])
            ->seeJsonContains(['title' => $secondJob->title])
            ->dontSeeJson(['title' => $jobWithNoTags->title]);
    }

    /** @test */
    public function can_query_for_a_specific_users_job()
    {
        $staff = create('App\Staff');
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $otherJob = create('App\Job');

        $this->get("/profiles/$staff->id/jobs")
            ->seeJsonContains([
                'title' => $job->title
            ])->dontSeeJson([
                'title' => $otherJob->title
            ]);
    }
}
