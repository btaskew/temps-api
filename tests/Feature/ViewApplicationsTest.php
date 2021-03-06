<?php

class ViewApplicationsTest extends TestCase
{
    /** @test */
    public function a_worker_can_view_their_applications()
    {
        $worker = loginWorker();
        create('App\Application', ['worker_id' => $worker->id]);

        $this->get('/profile/applications?token=' . $worker->user->token)
            ->seeJsonContains($worker->applications->toArray());
    }

    /** @test */
    public function a_worker_can_view_a_specific_application()
    {
        $worker = loginWorker();
        $application = create('App\Application', ['worker_id' => $worker->id]);

        $this->get("/profile/applications/$application->id?token=" . $worker->user->token)
            ->seeJsonContains($worker->applications()->first()->toArray());
    }

    /** @test */
    public function a_worker_can_also_see_the_applications_response()
    {
        $worker = loginWorker();
        $application = create('App\Application', ['worker_id' => $worker->id]);
        $response = create('App\ApplicationResponse', ['application_id' => $application->id]);

        $this->get("/profile/applications/$application->id?token=" . $worker->user->token)
            ->seeJsonContains([
                'comment' => $response->comment
            ]);
    }

    /** @test */
    public function a_staff_user_can_view_all_applications_for_a_specific_job()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        create('App\Application', ['job_id' => $job->id]);

        $this->get("/jobs/$job->id/applications?token=" . $staff->user->token)
            ->seeJsonContains($job->applications->toArray());
    }

    /** @test */
    public function a_staff_can_view_a_specific_application()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->get("/jobs/$job->id/applications/$application->id?token=" . $staff->user->token)
            ->seeJsonContains(['id' => $application->id]);
    }
}
