<?php

class UserTest extends TestCase
{
    /** @test */
    public function a_user_has_an_active_user_associated_with_it()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf('App\ActiveUser', $user->activeUser);
    }

    /** @test */
    public function creating_a_new_user_also_creates_an_active_user()
    {
        $user = factory('App\User')->create();

        $this->assertEquals(1, \App\ActiveUser::where('user_id', $user->id)->count());
    }

    /** @test */
    public function deleting_a_new_user_also_deletes_active_user()
    {
        $user = factory('App\User')->create();
        $user->delete();

        $this->assertEquals(0, \App\ActiveUser::where('user_id', $user->id)->count());
    }
}