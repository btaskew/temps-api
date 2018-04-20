<?php

class ViewApplicationsTest extends TestCase
{
    /** @test */
    public function a_worker_can_view_their_applications()
    {
        $worker = setActiveWorker();
        $worker->applications()->create();

        $this->get('/profiles/applications?token=' . $worker->user->activeUser->token)
            ->seeJsonContains($worker->applications->toArray());
    }

    /** @test */
    public function a_worker_can_view_a_specific_application()
    {
        $worker = setActiveWorker();
        $worker->applications()->create();
        $application = $worker->applications()->first();

        $this->get("/profiles/applications/$application->id?token=" . $worker->user->activeUser->token)
            ->seeJsonContains($worker->applications()->first()->toArray());
    }
}