<?php

class JobTest extends TestCase
{
    /** @test */
    public function a_job_is_owned_by_a_staff_user()
    {
        $job = create('App\Job');

        $this->assertInstanceOf('App\Staff', $job->owner);
    }

    /** @test */
    public function a_job_has_applications()
    {
        $job = create('App\Job');
        create('App\Application', ['job_id' => $job->id]);

        $this->assertInstanceOf('App\Application', $job->applications->first());
    }
}