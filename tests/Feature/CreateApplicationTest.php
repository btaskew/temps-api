<?php

class CreateApplicationTest extends TestCase
{
    /** @test */
    public function an_active_worker_can_apply_to_a_job()
    {
        $job = create('App\Job', ['staff_id' => '1']);
        $worker = loginWorker();
        $application = $this->createApplicationData($worker->id, $job->id);

        $this->post("/jobs/$job->id/apply?token=" . $worker->user->token, $application)
            ->seeInDatabase('applications', [
                'worker_id' => $worker->id,
                'job_id' => $job->id
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function applying_to_a_job_also_saves_given_experience()
    {
        $job = create('App\Job', ['staff_id' => '1']);
        $worker = loginWorker();
        $application = $this->createApplicationData($worker->id, $job->id);

        $this->post("/jobs/$job->id/apply?token=" . $worker->user->token, $application)
            ->seeInDatabase('application_experience', [
                'experience_id' => $application['experience'][0],
                'experience_id' => $application['experience'][1]
            ]);
    }

    /** @test */
    public function a_worker_cant_apply_to_a_job_past_its_closing_date()
    {
        $worker = loginWorker();
        $job = create('App\Job', ['closing_date' => \Carbon\Carbon::yesterday()]);
        $application = $this->createApplicationData($worker->id, $job->id);

        $this->post("/jobs/$job->id/apply?token=" . $worker->user->token, $application)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_cant_apply_to_a_job_with_no_open_vacancies()
    {
        $worker = loginWorker();
        $job = create('App\Job', ['open_vacancies' => 0]);
        $application = $this->createApplicationData($worker->id, $job->id);

        $this->post("/jobs/$job->id/apply?token=" . $worker->user->token, $application)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function an_inactive_user_cannot_apply_to_a_job()
    {
        $this->withExceptionHandling();

        $job = create('App\Job');

        $this->post("/jobs/$job->id/apply")
            ->assertResponseStatus(401);
    }

    /** @test */
    public function an_active_staff_user_cannot_apply_to_a_job()
    {
        $this->withExceptionHandling();

        $job = create('App\Job');
        $staff = loginStaff();

        $this->post("/jobs/$job->id/apply", ['token' => $staff->user->token])
            ->assertResponseStatus(403);
    }

    /**
     * @param string $workerId
     * @param string $jobId
     * @return array
     */
    private function createApplicationData(string $workerId, string $jobId)
    {
        return raw(
            'App\Application',
            [
                'worker_id' => $workerId,
                'job_id' => $jobId,
                'experience' => create('App\Experience', ['worker_id' => $workerId], 2)->pluck('id')->toArray(),
                'education' => create('App\Education', ['worker_id' => $workerId], 2)->pluck('id')->toArray()
            ]
        );
    }
}
