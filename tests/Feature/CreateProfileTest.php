<?php

class CreateProfileTest extends TestCase
{
    /** @test */
    public function a_worker_can_add_education_to_their_profile()
    {
        $worker = setActiveWorker();
        $education = raw('App\Education');

        $this->post('/profile/education?token=' . $worker->user->activeUser->token, $education)
            ->seeInDatabase('education', [
                'name' => $education['name'],
                'grade' => $education['grade']
            ]);
    }

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
    public function a_staff_cannot_add_experience()
    {
        $staff = setActiveStaff();
        $experience = raw('App\Experience');

        $this->post('/profile/experience?token=' . $staff->user->activeUser->token, $experience)
            ->assertResponseStatus(403);
    }
}