<?php

class UserTest extends TestCase
{
    /** @test */
    public function a_user_has_an_active_user_associated_with_it()
    {
        $user = create('App\User');
        create('App\ActiveUser', ['user_id' => $user->id]);

        $this->assertInstanceOf('App\ActiveUser', $user->activeUser);
    }

    /** @test */
    public function deleting_a_user_also_deletes_their_active_user()
    {
        $user = create('App\User');
        create('App\ActiveUser', ['user_id' => $user->id]);

        $user->delete();

        $this->assertEquals(0, \App\ActiveUser::where('user_id', $user->id)->count());
    }

    /** @test */
    public function a_user_can_set_their_active_user()
    {
        $user = create('App\User');

        $user->setActive();

        $this->assertInstanceOf('App\ActiveUser', $user->activeUser);
    }

    /** @test */
    public function a_user_has_a_role()
    {
        $role = create('App\Role');
        $user = create('App\User', ['role_id' => $role->id]);

        $this->assertInstanceOf('App\Role', $user->role);
    }

    /** @test */
    public function a_user_has_jobs()
    {
        $user = create('App\User');
        create('App\Job', ['user_id' => $user->id]);

        $this->assertInstanceOf('App\Job', $user->jobs->first());
    }

    /** @test */
    public function a_user_has_applications()
    {
        $user = create('App\User');
        create('App\Application', ['user_id' => $user->id]);

        $this->assertInstanceOf('App\Application', $user->applications->first());
    }
}