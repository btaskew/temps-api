<?php

class EducationTest extends TestCase
{
    /** @test */
    public function an_education_is_owned_by_a_worker()
    {
        $education = create('App\Education');

        $this->assertInstanceOf('App\Worker', $education->worker);
    }

    /** @test */
    public function an_education_belongs_to_many_applications()
    {
        $education = create('App\Education');
        $application = create('App\Application', ['worker_id' => $education->worker->id]);
        $education->applications()->attach($application->id);

        $this->assertInstanceOf('App\Application', $education->applications->first());
    }
}
