<?php

class JobTest extends TestCase
{
    /** @test */
    public function a_job_is_owned_by_a_user()
    {
        $job = factory('App\Job')->create();

        $this->assertInstanceOf('App\User', $job->owner);
    }
}