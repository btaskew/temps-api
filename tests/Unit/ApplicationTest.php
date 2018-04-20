<?php

class ApplicationTest extends TestCase
{
    /** @test */
    public function an_application_belongs_to_a_worker()
    {
        $application = create('App\Application');

        $this->assertInstanceOf('App\Worker', $application->owner);
    }

    /** @test */
    public function an_application_belongs_to_a_job()
    {
        $application = create('App\Application');

        $this->assertInstanceOf('App\Job', $application->job);
    }

    /** @test */
    public function an_application_knows_if_it_is_approved()
    {
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->assertFalse($application->isApproved());

        $job->update(['approved_application_id' => $application->id]);

        $this->assertTrue($application->fresh()->isApproved());
    }
}