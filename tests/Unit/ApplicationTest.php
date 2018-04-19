<?php

class ApplicationTest extends TestCase
{
    /** @test */
    public function an_application_belongs_to_a_user()
    {
        $application = create('App\Application');

        $this->assertInstanceOf('App\User', $application->user);
    }

    /** @test */
    public function an_application_belongs_to_a_job()
    {
        $application = create('App\Application');

        $this->assertInstanceOf('App\Job', $application->job);
    }
}