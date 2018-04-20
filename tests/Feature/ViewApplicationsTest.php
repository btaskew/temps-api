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

    /** @test */
    public function a_staff_user_can_view_all_applications_for_a_specific_job()
    {
        $staff = setActiveStaff();
        $job = $staff->jobs()->create();
        $job->applications()->create();

        $this->get("/jobs/$job->id/applications?token=" . $staff->user->activeUser->token)
            ->seeJsonContains($job->applications->toArray());

    }

    /** @test */
    public function a_staff_can_view_a_specific_application()
    {
        $staff = setActiveStaff();
        $job = $staff->jobs()->create();
        $application = $job->applications()->create();

        $this->get("/jobs/$job->id/applications/$application->id?token=" . $staff->user->activeUser->token)
            ->seeJsonContains($application->toArray());
    }
}