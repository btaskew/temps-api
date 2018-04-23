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
    public function can_only_search_for__jobs_that_havent_passed_their_closing_date()
    {
        $openJob = create('App\Job');
        $closedJob = create('App\Job', ['closing_date' => \Carbon\Carbon::yesterday()]);

        $this->get("/jobs")
            ->seeJsonContains([
                'title' => $openJob->title
            ])->dontSeeJson([
                'title' => $closedJob->title
            ]);
    }

    /** @test */
    public function can_only_search_for_jobs_that_have_vacancies()
    {
        $jobWithVacancies = create('App\Job', ['open_vacancies' => 2]);
        $jobWithNoVacancies = create('App\Job', ['open_vacancies' => 0]);

        $this->get("/jobs")
            ->seeJsonContains([
                'title' => $jobWithVacancies->title
            ])->dontSeeJson([
                'title' => $jobWithNoVacancies->title
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
