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
    public function an_application_can_have_a_response()
    {
        $application = create('App\Application');
        create('App\ApplicationResponse', ['application_id' => $application->id]);

        $this->assertInstanceOf('App\ApplicationResponse', $application->response);
    }

    /** @test */
    public function an_application_has_many_experiences()
    {
        $application = create('App\Application');
        $experience = create('App\Experience', ['worker_id' => $application->owner->id]);
        $application->experience()->attach($experience->id);

        $this->assertInstanceOf('App\Experience', $application->experience->first());
    }

    /** @test */
    public function an_application_knows_if_it_is_approved()
    {
        $application = create('App\Application');

        $this->assertFalse($application->isApproved());

        create(
            'App\ApplicationResponse',
            ['application_id' => $application->id, 'type' => 'approved']
        );

        $this->assertTrue($application->fresh()->isApproved());
    }
}