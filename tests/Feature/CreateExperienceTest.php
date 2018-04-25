<?php

class CreateExperienceTest extends TestCase
{
    /** @test */
    public function a_worker_can_add_experience_to_their_profile()
    {
        $worker = loginWorker();
        $experience = raw('App\Experience');

        $this->post('/profile/experience?token=' . $worker->user->token, $experience)
            ->seeInDatabase('experience', [
                'type' => $experience['type'],
                'title' => $experience['title']
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_staff_cannot_add_experience()
    {
        $staff = loginStaff();
        $experience = raw('App\Experience');

        $this->post('/profile/experience?token=' . $staff->user->token, $experience)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_can_edit_their_experience()
    {
        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id]);

        $this->patch(
                "/profile/experience/$experience->id?token=" . $worker->user->token,
                ['description' => 'New description']
            )
            ->seeInDatabase('experience', [
                'description' => 'New description'
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_worker_cant_edit_someone_elses_experience()
    {
        $this->withExceptionHandling();

        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id + 1]);

        $this->patch(
            "/profile/experience/$experience->id?token=" . $worker->user->token,
            ['grade' => 'New grade']
        )
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_can_delete_their_experience()
    {
        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id]);

        $this->delete("/profile/experience/$experience->id?token=" . $worker->user->token)
            ->notSeeInDatabase('experience', [
                'grade' => 'New grade'
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_worker_cant_delete_someone_elses_experience()
    {
        $this->withExceptionHandling();

        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id + 1]);

        $this->delete("/profile/experience/$experience->id?token=" . $worker->user->token)
            ->assertResponseStatus(403);
    }
}
