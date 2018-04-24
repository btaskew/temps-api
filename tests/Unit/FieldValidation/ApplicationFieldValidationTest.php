<?php

class ApplicationFieldValidationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->withExceptionHandling();
    }

    /** @test */
    public function an_application_requires_experience()
    {
        $job = create('App\Job', ['staff_id' => '1']);
        $worker = setActiveWorker();
        $application = raw('App\Application',
            ['worker_id' => $worker->id, 'job_id' => $job->id]
        );;

        $this->post("/jobs/$job->id/apply?token=" . $worker->user->activeUser->token, $application)
            ->assertContains("The experience field is required.", $this->response->content());
    }

    /** @test */
    public function an_application_requires_a_cover_letter()
    {
        $job = create('App\Job', ['staff_id' => '1']);
        $worker = setActiveWorker();
        $application = raw('App\Application',
            ['worker_id' => $worker->id, 'job_id' => $job->id, 'experience' => [1], 'cover_letter' => null]
        );;

        $this->post("/jobs/$job->id/apply?token=" . $worker->user->activeUser->token, $application)
            ->assertContains("The cover letter field is required.", $this->response->content());
    }
}