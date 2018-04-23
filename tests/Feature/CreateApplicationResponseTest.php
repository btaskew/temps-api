<?php

class CreateApplicationResponseTest extends TestCase
{
    /** @test */
    public function a_staff_user_can_approve_an_application_for_their_job()
    {
        list($application, $path) = $this->runFactories();

        $this->assertFalse($application->isApproved());

        $this->post(
            $path,
            [
                'type' => 'approved',
                'comment' => 'You are perfect for this job'
            ]
        )->assertTrue($application->fresh()->isApproved());

        $this->seeInDatabase('application_responses', ['application_id' => $application->id]);
    }

    /** @test */
    public function a_staff_user_can_reject_an_application_for_their_job()
    {
        list($application, $path) = $this->runFactories();

        $this->assertFalse($application->isApproved());

        $this->post(
            $path,
            [
                'type' => 'rejected',
                'comment' => 'This is not the job for you'
            ]
        )->assertFalse($application->fresh()->isApproved());

        $this->seeInDatabase('application_responses', ['application_id' => $application->id]);
    }

    /** @test */
    public function applications_can_only_have_one_response_made()
    {
        list($application, $path) = $this->runFactories();
        create('App\ApplicationResponse', ['application_id' => $application->id]);

        $this->post(
            $path,
            [
                'type' => 'rejected',
                'comment' => 'This is not the job for you'
            ]
        )->assertResponseStatus(409);
    }

    /** @test */
    public function staff_cannot_approve_an_application_for_someone_elses_job()
    {
        $this->withExceptionHandling();

        $staff = setActiveStaff();
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/respond?token=" . $staff->user->activeUser->token
        )->assertResponseStatus(403);
    }

    /** @test */
    public function workers_cannot_approve_an_application()
    {
        $this->withExceptionHandling();

        $worker = setActiveWorker();
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/respond?token=" . $worker->user->activeUser->token
        )->assertResponseStatus(403);
    }

    /**
     * @return array
     */
    private function runFactories()
    {
        $staff = setActiveStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $application = create('App\Application', ['job_id' => $job->id]);
        $path = "/jobs/$job->id/applications/$application->id/respond?token=" . $staff->user->activeUser->token;
        return [$application, $path];
    }
}