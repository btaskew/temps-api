<?php

class CreateApplicationTest extends TestCase
{
    /** @test */
    public function an_active_worker_can_apply_to_a_job()
    {
        $job = create('App\Job', ['staff_id' => '1']);
        $worker = setActiveWorker();

        $this->post("/jobs/$job->id/apply", ['token' => $worker->user->activeUser->token])
            ->seeInDatabase('applications', [
                'worker_id' => $worker->id,
                'job_id' => $job->id
            ]);
    }

    /** @test */
    public function a_worker_cant_apply_to_a_job_past_its_closing_date()
    {
        $worker = setActiveWorker();
        $job = create('App\Job', ['closing_date' => \Carbon\Carbon::yesterday()]);

        $this->post("/jobs/$job->id/apply", ['token' => $worker->user->activeUser->token])
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_cant_apply_to_a_job_with_no_open_vacancies()
    {
        $worker = setActiveWorker();
        $job = create('App\Job', ['open_vacancies' => 0]);

        $this->post("/jobs/$job->id/apply", ['token' => $worker->user->activeUser->token])
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
        $staff = setActiveStaff();

        $this->post("/jobs/$job->id/apply", ['token' => $staff->user->activeUser->token])
            ->assertResponseStatus(403);
    }
}