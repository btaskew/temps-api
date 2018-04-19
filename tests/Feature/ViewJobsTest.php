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
    public function can_query_for_a_specific_users_job()
    {
        $user = create('App\User', ['role_id' => 1]);
        $job = create('App\Job', ['user_id' => $user->id]);
        $otherJob = create('App\Job');

        $this->get("/profiles/$user->id/jobs")
            ->seeJsonContains([
                'title' => $job->title
            ])->dontSeeJson([
                'title' => $otherJob->title
            ]);
    }
}
