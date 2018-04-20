<?php

class CreateApplicationTest extends TestCase
{
    /** @test */
    public function an_active_worker_can_apply_to_a_job()
    {
        $job = create('App\Job', ['staff_id' => '1']);
        $worker = setActiveWorker();

        $this->post("/jobs/apply/$job->id", ['token' => $worker->user->activeUser->token])
            ->seeInDatabase('applications', [
                'worker_id' => $worker->id,
                'job_id' => $job->id
            ]);
    }

    /** @test */
    public function an_inactive_user_cannot_apply_to_a_job()
    {
        $job = create('App\Job');

        $this->post("/jobs/apply/$job->id")
            ->assertResponseStatus(401);
    }


    /** @test */
    public function an_active_staff_user_cannot_apply_to_a_job()
    {
        $job = create('App\Job');
        $staff = setActiveStaff();

        $this->post("/jobs/apply/$job->id", ['token' => $staff->user->activeUser->token])
            ->assertResponseStatus(403);
    }
}