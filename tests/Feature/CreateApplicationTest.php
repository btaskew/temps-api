<?php

class CreateApplicationTest extends TestCase
{
    /** @test */
    public function any_active_user_can_apply_to_a_job()
    {
        $job = create('App\Job');
        $user = setActiveWorker();

        $this->post("/jobs/apply/$job->id", ['token' => $user->activeUser->token])
            ->seeInDatabase('applications', [
                'user_id' => $user->id,
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
}