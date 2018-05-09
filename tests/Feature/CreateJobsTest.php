<?php

class CreateJobsTest extends TestCase
{
    /** @test */
    public function an_active_staff_user_can_create_a_new_job()
    {
        $staff = loginStaff();

        $job = raw('App\Job', [
            'tags' => ['foo', 'bar']
        ]);

        $this->post('/jobs?token=' . $staff->user->token, $job)
            ->seeInDatabase('jobs', [
                'title' => $job['title'],
                'description' => $job['description']
            ]);

        $this->assertContains('id', $this->response->content());
    }

    /** @test */
    public function creating_a_job_saves_jobs_tags()
    {
        $staff = loginStaff();

        $job = raw('App\Job', [
            'tags' => ['foo', 'bar']
        ]);

        $this->post('/jobs?token=' . $staff->user->token, $job)
            ->seeInDatabase('tags', ['tag' => 'foo', 'tag' => 'bar']);
    }

    /** @test */
    public function a_job_has_to_have_at_least_one_open_vacancy()
    {
        $this->withExceptionHandling();

        $staff = loginStaff();

        $job = factory('App\Job')->raw([
            'open_vacancies' => 0,
            'tags' => ['foo', 'bar']
        ]);

        $this->post('/jobs?token=' . $staff->user->token, $job)
            ->assertContains('The open vacancies must be at least 1.', $this->response->content());
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

        $worker = loginWorker();

        $job = raw('App\Job');

        $this->post('/jobs?token=' . $worker->user->token, $job)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_jobs_owner_can_delete_their_job()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);

        $this->delete("/jobs/$job->id", ['token' => $staff->user->token])
            ->notSeeInDatabase('jobs', $job->getAttributes());
    }

    /** @test */
    public function a_staff_user_cant_delete_another_users_job()
    {
        $this->withExceptionHandling();

        $staff = create('App\Staff');
        $job = create('App\Job', ['staff_id' => $staff->id]);

        $otherStaff = loginStaff();

        $this->delete("/jobs/$job->id", ['token' => $otherStaff->user->token])
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_cannot_delete_a_job()
    {
        $this->withExceptionHandling();

        $job = factory('App\Job')->create([
            'staff_id' => '1'
        ]);

        $worker = loginWorker();

        $this->delete("/jobs/$job->id", ['token' => $worker->user->token])
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_jobs_owner_can_edit_their_job()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);

        $this->patch("/jobs/$job->id", ['token' => $staff->user->token, "title" => "New title"])
            ->seeInDatabase('jobs', [
                'title' => 'New title'
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_jobs_owner_can_edit_tags_for_their_job()
    {
        $staff = loginStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $job->saveTags(['foo']);

        $this->patch("/jobs/$job->id", ['token' => $staff->user->token, "tags" => ['foo', 'bar']])
            ->seeInDatabase('tags', [
                'tag' => 'foo',
                'tag' => 'bar',
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_staff_user_cant_update_another_users_job()
    {
        $this->withExceptionHandling();

        $staff = create('App\Staff');
        $job = create('App\Job', ['staff_id' => $staff->id]);

        $otherStaff = loginStaff();

        $this->patch("/jobs/$job->id", ['token' => $otherStaff->user->token])
            ->assertResponseStatus(403);
    }
}
