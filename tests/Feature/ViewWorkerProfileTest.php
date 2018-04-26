<?php

class ViewWorkerProfileTest extends TestCase
{
    /** @test */
    public function a_worker_can_view_their_user_information_on_their_profile()
    {
        $worker = loginWorker();

        $this->get("/profile/$worker->id?token=" . $worker->user->token)
            ->seeJson([
                'website' => $worker->website,
                'email' => $worker->user->email
            ]);
    }

    /** @test */
    public function a_worker_can_only_view_their_profile()
    {
        $this->withExceptionHandling();

        $worker = create('App\Worker');
        $otherWorker = loginWorker();

        $this->get("/profile/$worker->id?token=" . $otherWorker->user->token)
            ->assertResponseStatus(403);
    }
}