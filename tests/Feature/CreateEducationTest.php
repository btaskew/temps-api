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
    }

    /** @test */
    public function a_staff_cannot_add_education()
    {
        $staff = setActiveStaff();
        $education = raw('App\Education');

        $this->post('/profile/education?token=' . $staff->user->activeUser->token, $education)
            ->assertResponseStatus(403);
    }
}