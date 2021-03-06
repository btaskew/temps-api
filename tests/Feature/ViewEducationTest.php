<?php

class ViewEducationTest extends TestCase
{
    /** @test */
    public function can_view_users_education()
    {
        $worker = loginWorker();
        $education = create('App\Education', ['worker_id' => $worker->id], 2);

        $this->get('/profile/education?token=' . $worker->user->token)
            ->seeJson([
                'name' => $education->first()->name,
                'grade' => $education->last()->grade,
            ]);
    }

    /** @test */
    public function can_view_specific_education()
    {
        $worker = loginWorker();
        $education = create('App\Education', ['worker_id' => $worker->id], 2);

        $this->get('/profile/education/' . $education->first()->id . '?token=' . $worker->user->token)
            ->seeJson([
                'name' => $education->first()->name,
            ])
            ->dontSeeJson([
                'name' => $education->last()->name,
            ]);
    }

    /** @test */
    public function cant_view_other_users_education()
    {
        $worker = loginWorker();
        $education = create('App\Education', ['worker_id' => $worker->id + 1]);

        $this->get('/profile/education?token=' . $worker->user->token)
            ->dontSeeJson([
                'name' => $education->name,
            ]);
    }

    /** @test */
    public function cant_view_other_users_specific_education()
    {
        $this->withExceptionHandling();

        $worker = loginWorker();
        $education = create('App\Education', ['worker_id' => $worker->id + 1]);

        $this->get('/profile/education/' . $education->id . '?token=' . $worker->user->token)
            ->seeStatusCode(403);
    }
}
