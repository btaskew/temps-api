<?php

class StaffTest extends TestCase
{
    /** @test */
    public function a_staff_has_jobs()
    {
        $staff = create('App\Staff');
        create('App\Job', ['staff_id' => $staff->id]);

        $this->assertInstanceOf('App\Job', $staff->jobs->first());
    }

    /** @test */
    public function a_staff_has_a_user_entity()
    {
        $staff = create('App\Staff');

        $this->assertInstanceOf('App\User', $staff->user);
    }
}
