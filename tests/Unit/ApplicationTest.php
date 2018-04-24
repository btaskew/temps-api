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

    /** @test */
    public function cant_add_non_existing_experience_to_an_application()
    {
        $this->withExceptionHandling();

        $application = create('App\Application');

        $this->expectException('Illuminate\Database\Eloquent\ModelNotFoundException');

        $application->saveExperience([1]);
    }

    /** @test */
    public function cant_add_another_users_experience_to_an_application()
    {
        $this->withExceptionHandling();

        $worker = create('App\Worker', ['id' => 1]);
        $this->actingAs($worker->user);
        $application = create('App\Application', ['worker_id' => $worker->id]);
        $otherUsersExperience = create('App\Experience', ['worker_id' => 2]);

        $this->expectException('Illuminate\Validation\UnauthorizedException');

        $application->saveExperience([$otherUsersExperience->id]);
    }
}