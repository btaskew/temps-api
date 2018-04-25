<?php

class ExperienceTest extends TestCase
{
    /** @test */
    public function an_experience_is_owned_by_a_worker()
    {
        $experience = create('App\Experience');

        $this->assertInstanceOf('App\Worker', $experience->worker);
    }

    /** @test */
    public function an_experience_belongs_to_many_applications()
    {
        $experience = create('App\Experience');
        $application = create('App\Application', ['worker_id' => $experience->worker->id]);
        $experience->applications()->attach($application->id);

        $this->assertInstanceOf('App\Application', $experience->applications->first());
    }
}
