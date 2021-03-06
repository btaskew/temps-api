<?php

class CreateApplicationResponseTest extends TestCase
{
    /** @test */
    public function a_staff_user_can_approve_an_application_for_their_job()
    {
        [$application, $path] = $this->runFactories();

        $this->assertFalse($application->isApproved());

        $this->post(
            $path,
            [
                'type' => 'approved',
                'comment' => 'You are perfect for this job',
                'reject_all' => false
            ]
        )->assertTrue($application->fresh()->isApproved());

        $this->seeInDatabase('application_responses', ['application_id' => $application->id]);
        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_staff_user_can_reject_an_application_for_their_job()
    {
        [$application, $path] = $this->runFactories();

        $this->assertFalse($application->isApproved());

        $this->post(
            $path,
            [
                'type' => 'rejected',
                'comment' => 'This is not the job for you',
                'reject_all' => false
            ]
        )->assertFalse($application->fresh()->isApproved());

        $this->seeInDatabase('application_responses', ['application_id' => $application->id]);
        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function staff_can_automatically_reject_other_applications_on_approval()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $applications = create('App\Application', ['job_id' => $job->id], 2);

        $this->post(
            "/jobs/$job->id/applications/". $applications[0]->id .
                "/respond?token=" . $staff->user->token,
            [
                'type' => 'approved',
                'comment' => 'You are perfect for this job',
                'reject_all' => true
            ]
        )->assertTrue($applications[0]->isApproved());

        $this->assertTrue($applications[1]->response->type == 'rejected');
        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function approving_an_application_reduces_the_jobs_open_vacancies()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id, 'open_vacancies' => 2]);
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/respond?token=" . $staff->user->token,
            [
                'type' => 'approved',
                'comment' => 'You are perfect for this job',
                'reject_all' => false
            ]
        )->assertEquals(1, $job->fresh()->open_vacancies);
    }

    /** @test */
    public function applications_can_only_have_one_response_made()
    {
        [$application, $path] = $this->runFactories();
        create('App\ApplicationResponse', ['application_id' => $application->id]);

        $this->post(
            $path,
            [
                'type' => 'rejected',
                'comment' => 'This is not the job for you',
                'reject_all' => false
            ]
        )->assertResponseStatus(409);
    }

    /** @test */
    public function staff_cannot_approve_an_application_for_someone_elses_job()
    {
        $this->withExceptionHandling();

        $staff = loginStaff();
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/respond?token=" . $staff->user->token
        )->assertResponseStatus(403);
    }

    /** @test */
    public function workers_cannot_approve_an_application()
    {
        $this->withExceptionHandling();

        $worker = loginWorker();
        $job = create('App\Job');
        $application = create('App\Application', ['job_id' => $job->id]);

        $this->post(
            "/jobs/$job->id/applications/$application->id/respond?token=" . $worker->user->token
        )->assertResponseStatus(403);
    }

    /**
     * @return array
     */
    private function runFactories()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $application = create('App\Application', ['job_id' => $job->id]);
        $path = "/jobs/$job->id/applications/$application->id/respond?token=" . $staff->user->token;
        return [$application, $path, $job];
    }
}
