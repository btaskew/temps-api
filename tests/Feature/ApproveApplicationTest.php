<?php

class ApproveApplicationTest extends TestCase
{
    /** @test */
    public function a_staff_user_can_approve_an_application_for_their_job()
    {
        $staff = setActiveStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->assertFalse($application->isApproved());

        $this->post(
            "/jobs/$job->id/applications/$application->id/approve?token=" . $staff->user->activeUser->token
        )->assertTrue($application->fresh()->isApproved());
    }

    /** @test */
    public function staff_cannot_approve_an_application_for_someone_elses_job()
    {
        $this->withExceptionHandling();

        $staff = setActiveStaff();
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/approve?token=" . $staff->user->activeUser->token
        )->assertResponseStatus(403);

        $this->assertFalse($application->isApproved());
    }

    /** @test */
    public function workers_cannot_approve_an_application()
    {
        $this->withExceptionHandling();

        $worker = setActiveWorker();
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/approve?token=" . $worker->user->activeUser->token
        )->assertResponseStatus(403);

        $this->assertFalse($application->isApproved());
    }
}