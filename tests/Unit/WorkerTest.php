<?php

class WorkerTest extends TestCase
{
    /** @test */
    public function a_worker_has_applications()
    {
        $worker = create('App\Worker');
        create('App\Application', ['worker_id' => $worker->id]);

        $this->assertInstanceOf('App\Application', $worker->applications->first());
    }

    /** @test */
    public function a_worker_has_a_user_entity()
    {
        $worker = create('App\Worker');

        $this->assertInstanceOf('App\User', $worker->user);
    }

    /** @test */
    public function a_worker_has_multiple_experiences()
    {
        $worker = create('App\Worker');
        create('App\Experience', ['worker_id' => $worker->id]);

        $this->assertInstanceOf('App\Experience', $worker->experience->first());
    }

    /** @test */
    public function a_worker_has_multiple_educations()
    {
        $worker = create('App\Worker');
        create('App\Education', ['worker_id' => $worker->id]);

        $this->assertInstanceOf('App\Education', $worker->education->first());
    }
}