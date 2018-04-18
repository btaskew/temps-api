<?php

class UserTest extends TestCase
{
    /** @test */
    public function a_user_has_an_active_user_associated_with_it()
    {
        $user = factory('App\User')->create();
        factory('App\ActiveUser')->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf('App\ActiveUser', $user->activeUser);
    }

    /** @test */
    public function deleting_a_user_also_deletes_their_active_user()
    {
        $user = factory('App\User')->create();
        factory('App\ActiveUser')->create([
            'user_id' => $user->id
        ]);

        $user->delete();

        $this->assertEquals(0, \App\ActiveUser::where('user_id', $user->id)->count());
    }

    /** @test */
    public function a_user_can_set_their_active_user()
    {
        $user = factory('App\User')->create();

        $user->setActive();

        $this->assertInstanceOf('App\ActiveUser', $user->activeUser);
    }

    /** @test */
    public function a_user_has_a_role()
    {
        $role = factory('App\Role')->create();

        $user = factory('App\User')->create([
            'role_id' => $role->id
        ]);


        $this->assertInstanceOf('App\Role', $user->role);
    }
}