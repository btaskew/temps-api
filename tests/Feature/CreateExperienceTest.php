<?php

class CreateExperienceTest extends TestCase
{
    /** @test */
    public function a_worker_can_add_experience_to_their_profile()
    {
        $worker = setActiveWorker();
        $experience = raw('App\Experience');

        $this->post('/profile/experience?token=' . $worker->user->activeUser->token, $experience)
            ->seeInDatabase('experience', [
                'type' => $experience['type'],
                'title' => $experience['title']
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_staff_cannot_add_experience()
    {
        $staff = setActiveStaff();
        $experience = raw('App\Experience');

        $this->post('/profile/experience?token=' . $staff->user->activeUser->token, $experience)
            ->assertResponseStatus(403);
    }
}