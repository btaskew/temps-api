<?php

class CreateEducationTest extends TestCase
{
    /** @test */
    public function a_worker_can_add_education()
    {
        $worker = setActiveWorker();
        $education = raw('App\Education');

        $this->post('/profile/education?token=' . $worker->user->activeUser->token, $education)
            ->seeInDatabase('education', [
                'name' => $education['name'],
                'grade' => $education['grade']
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_staff_cannot_add_education()
    {
        $staff = setActiveStaff();
        $education = raw('App\Education');

        $this->post('/profile/education?token=' . $staff->user->activeUser->token, $education)
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_can_edit_their_education()
    {
        $worker = setActiveWorker();
        $education = create('App\Education', ['worker_id' => $worker->id]);

        $this->patch(
                "/profile/education/$education->id?token=" . $worker->user->activeUser->token,
                ['grade' => 'New grade']
            )
            ->seeInDatabase('education', [
                'grade' => 'New grade'
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_worker_cant_edit_someone_elses_education()
    {
        $this->withExceptionHandling();

        $worker = setActiveWorker();
        $education = create('App\Education', ['worker_id' => $worker->id + 1]);

        $this->patch(
                "/profile/education/$education->id?token=" . $worker->user->activeUser->token,
                ['grade' => 'New grade']
            )
            ->assertResponseStatus(403);
    }

    /** @test */
    public function a_worker_can_delete_their_education()
    {
        $worker = setActiveWorker();
        $education = create('App\Education', ['worker_id' => $worker->id]);

        $this->delete("/profile/education/$education->id?token=" . $worker->user->activeUser->token)
            ->notSeeInDatabase('education', [
                'grade' => 'New grade'
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_worker_cant_delete_someone_elses_education()
    {
        $this->withExceptionHandling();

        $worker = setActiveWorker();
        $education = create('App\Education', ['worker_id' => $worker->id + 1]);

        $this->delete("/profile/education/$education->id?token=" . $worker->user->activeUser->token)
            ->assertResponseStatus(403);
    }
}
