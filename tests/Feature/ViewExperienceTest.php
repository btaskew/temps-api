<?php

class ViewExperienceTest extends TestCase
{
    /** @test */
    public function can_view_users_experience()
    {
        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id], 2);

        $this->get('/profile/experience?token=' . $worker->user->token)
            ->seeJson([
                'title' => $experience->first()->title,
                'type' => $experience->last()->type,
            ]);
    }

    /** @test */
    public function can_view_specific_experience()
    {
        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id], 2);

        $this->get('/profile/experience/' . $experience->first()->id . '?token=' . $worker->user->token)
            ->seeJson([
                'title' => $experience->first()->title,
            ])
            ->dontSeeJson([
                'title' => $experience->last()->title,
            ]);
    }

    /** @test */
    public function cant_view_other_users_experience()
    {
        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id + 1]);

        $this->get('/profile/experience?token=' . $worker->user->token)
            ->dontSeeJson([
                'title' => $experience->title,
            ]);
    }

    /** @test */
    public function cant_view_other_users_specific_experience()
    {
        $this->withExceptionHandling();

        $worker = loginWorker();
        $experience = create('App\Experience', ['worker_id' => $worker->id + 1]);

        $this->get('/profile/experience/' . $experience->id . '?token=' . $worker->user->token)
            ->seeStatusCode(403);
    }
}
