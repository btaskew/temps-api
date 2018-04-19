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
}