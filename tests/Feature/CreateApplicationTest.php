<?php

class CreateApplicationTest extends TestCase
{
    /** @test */
    public function any_user_can_apply_to_a_job()
    {
        $job = create('App\Job');
        $user = setActiveWorker();

        $this->post("/jobs/apply/$job->id", ['token' => $user->activeUser->token])
            ->seeInDatabase('applications', [
                'user_id' => $user->id,
                'job_id' => $job->id
            ]);
    }
}