<?php

class CreateJobsTest extends TestCase
{
    /** @test */
    public function an_active_staff_user_can_create_a_new_job()
    {
        $user = setActiveStaff();

        $job =factory('App\Job')->raw([
            'user_id' => $user->id
        ]);

        $this->post('/jobs?token=' . $user->activeUser->token, $job)
            ->seeInDatabase('jobs', $job);
    }

    /** @test */
    public function an_inactive_staff_user_cannot_create_a_job()
    {
        create('App\User', ['role_id' => 1]);

        $job =factory('App\Job')->raw();

        $this->post('/jobs', $job)
            ->assertResponseStatus(401);
    }

    /** @test */
    public function an_active_worker_user_cannot_create_a_job()
    {
        $user = setActiveWorker();

        $job = raw('App\Job');

        $this->post('/jobs?token=' . $user->activeUser->token, $job)
            ->assertResponseStatus(401);
    }

    /** @test */
    public function a_job_requires_a_title()
    {
        $user = setActiveStaff();

        $this->post('/jobs?token=' . $user->activeUser->token, ['description' => 'Test job'])
            ->assertResponseStatus(422);
    }

    /** @test */
    public function a_job_requires_a_description()
    {
        $user = setActiveStaff();

        $this->post('/jobs?token=' . $user->activeUser->token, ['title' => 'Test job'])
            ->assertResponseStatus(422);
    }
}