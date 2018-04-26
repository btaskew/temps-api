<?php

class EditWorkerProfileTest extends TestCase
{
    /** @test */
    public function a_worker_can_edit_their_information()
    {
        $worker = loginWorker();

        $this->patch("/profile/$worker->id?token=" . $worker->user->token, ['website' => 'New website'])
            ->seeInDatabase('workers', [
                'website' => 'New website'
            ]);

        $this->assertContains('success', $this->response->content());
    }

    /** @test */
    public function a_worker_can_only_edit_their_profile()
    {
        $this->withExceptionHandling();

        $worker = create('App\Worker');
        $otherWorker = loginWorker();

        $this->patch("/profile/$worker->id?token=" . $otherWorker->user->token, ['website' => 'New website'])
            ->assertResponseStatus(403);
    }
}