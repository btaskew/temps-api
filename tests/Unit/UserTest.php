<?php

class UserTest extends TestCase
{
    /** @test */
    public function a_user_can_have_a_worker()
    {
        $user = create('App\User');
        create('App\Worker', ['user_id' => $user->id]);

        $this->assertInstanceOf('App\Worker', $user->worker);
    }

    /** @test */
    public function a_user_can_have_a_staff()
    {
        $user = create('App\User');
        create('App\Staff', ['user_id' => $user->id]);

        $this->assertInstanceOf('App\Staff', $user->staff);
    }

    /** @test */
    public function you_can_get_a_users_type()
    {
        $staffUser = create('App\User');
        create('App\Staff', ['user_id' => $staffUser->id]);

        $this->assertEquals('staff', $staffUser->type);

        $workerUser = create('App\User');
        create('App\Worker', ['user_id' => $workerUser->id]);

        $this->assertEquals('worker', $workerUser->type);
    }
}