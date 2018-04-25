<?php

class ViewApplicationsTest extends TestCase
{
    /** @test */
    public function a_worker_can_view_their_applications()
    {
        $worker = setActiveWorker();
        create('App\Application', ['worker_id' => $worker->id]);

        $this->get('/profile/applications?token=' . $worker->user->activeUser->token)
            ->seeJsonContains($worker->applications->toArray());
    }

    /** @test */
    public function a_worker_can_view_a_specific_application()
    {
        $worker = setActiveWorker();
        $application = create('App\Application', ['worker_id' => $worker->id]);

        $this->get("/profile/applications/$application->id?token=" . $worker->user->activeUser->token)
            ->seeJsonContains($worker->applications()->first()->toArray());
    }

    /** @test */
    public function a_staff_user_can_view_all_applications_for_a_specific_job()
    {
        $staff = setActiveStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        create('App\Application', ['job_id' => $job->id]);

        $this->get("/jobs/$job->id/applications?token=" . $staff->user->activeUser->token)
            ->seeJsonContains($job->applications->toArray());
    }

    /** @test */
    public function a_staff_can_view_a_specific_application()
    {
        $staff = setActiveStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->get("/jobs/$job->id/applications/$application->id?token=" . $staff->user->activeUser->token)
            ->seeJsonContains(['id' => $application->id]);
    }
}
