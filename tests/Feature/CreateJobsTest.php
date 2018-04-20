<?php

class CreateJobsTest extends TestCase
{
    /** @test */
    public function an_active_staff_user_can_create_a_new_job()
    {
        $staff = setActiveStaff();

        $job = factory('App\Job')->raw([
            'staff_id' => $staff->id
        ]);
        $job['tags'] = ['foo', 'bar'];

        $this->post('/jobs?token=' . $staff->user->activeUser->token, $job)
            ->seeInDatabase('jobs', [
                'title' => $job['title'],
                'description' => $job['description']
            ]);
    }

    /** @test */
    public function creating_a_job_saves_jobs_tags()
    {
        $staff = setActiveStaff();

        $job = factory('App\Job')->raw([
            'staff_id' => $staff->id,
            'tags' => ['foo', 'bar']
        ]);

        $this->post('/jobs?token=' . $staff->user->activeUser->token, $job)
            ->seeInDatabase('tags', ['tag' => 'foo', 'tag' => 'bar']);
    }

    /** @test */
    public function an_inactive_staff_user_cannot_create_a_job()
    {
        $this->withExceptionHandling();

        create('App\Staff');

        $job =factory('App\Job')->raw();

        $this->post('/jobs', $job)
            ->assertResponseStatus(401);
    }

    /** @test */
    public function an_active_worker_user_cannot_create_a_job()
    {
        $this->withExceptionHandling();

        $worker = setActiveWorker();

        $job = raw('App\Job');

        $this->post('/jobs?token=' . $worker->user->activeUser->token, $job)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_job_requires_a_title()
    {
        $this->withExceptionHandling();

        $staff = setActiveStaff();

        $this->post('/jobs?token=' . $staff->user->activeUser->token, ['description' => 'Test job'])
            ->assertResponseStatus(422);
    }

    /** @test */
    public function a_job_requires_a_description()
    {
        $this->withExceptionHandling();

        $staff = setActiveStaff();

        $this->post('/jobs?token=' . $staff->user->activeUser->token, ['title' => 'Test job'])
            ->assertResponseStatus(422);
    }

    /** @test */
    public function a_jobs_owner_can_delete_their_job()
    {
        $staff = setActiveStaff();

        $job = $staff->jobs()->create();

        $this->delete('/jobs/' . $job->id, ['token' => $staff->user->activeUser->token])
            ->notSeeInDatabase('jobs', $job->getAttributes());
    }

    /** @test */
    public function a_staff_user_cant_delete_another_users_job()
    {
        $this->withExceptionHandling();

        $staff = create('App\Staff');
        $job = $staff->jobs()->create();

        $otherStaff = setActiveStaff();

        $this->delete('/jobs/' . $job->id, ['token' => $otherStaff->user->activeUser->token])
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_cannot_delete_a_job()
    {
        $this->withExceptionHandling();

        $job = factory('App\Job')->create([
            'staff_id' => '1'
        ]);

        $worker = setActiveWorker();

        $this->delete('/jobs/' . $job->id, ['token' => $worker->user->activeUser->token])
            ->assertResponseStatus(403);
    }
}