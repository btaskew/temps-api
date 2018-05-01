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
        $job->saveTags(['foo']);
        $jobWithDifferantTags = create('App\Job');
        $jobWithDifferantTags->saveTags(['bar']);

        $this->get('/jobs?tags=foo')
            ->seeJsonContains(['title' => $job->title])
            ->dontSeeJson(['title' => $jobWithDifferantTags->title]);
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
    public function can_query_for_jobs_by_duration()
    {
        $validJob = create('App\Job', ['duration' => 2]);
        $invalidJob = create('App\Job', ['duration' => 5]);

        $this->get('/jobs?minDuration=1&maxDuration=3')
            ->seeJsonContains(['title' => $validJob->title])
            ->dontSeeJson(['title' => $invalidJob->title]);
    }

    /** @test */
    public function can_query_for_jobs_by_hourly_rate()
    {
        $validJob = create('App\Job', ['rate' => 2]);
        $invalidJob = create('App\Job', ['rate' => 5]);

        $this->get('/jobs?minRate=1&maxRate=3')
            ->seeJsonContains(['title' => $validJob->title])
            ->dontSeeJson(['title' => $invalidJob->title]);
    }

    /** @test */
    public function a_staff_user_can_query_for_their_jobs()
    {
        $staff = create('App\Staff');
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $otherJob = create('App\Job');

        $this->get("/jobs?owner=$staff->id")
            ->seeJsonContains([
                'title' => $job->title
            ])->dontSeeJson([
                'title' => $otherJob->title
            ]);
    }
}
