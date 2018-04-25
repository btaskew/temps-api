<?php

class JobTest extends TestCase
{
    /** @test */
    public function a_job_is_owned_by_a_staff_user()
    {
        $job = create('App\Job');

        $this->assertInstanceOf('App\Staff', $job->owner);
    }

    /** @test */
    public function a_job_has_applications()
    {
        $job = create('App\Job');
        create('App\Application', ['job_id' => $job->id]);

        $this->assertInstanceOf('App\Application', $job->applications->first());
    }

    /** @test */
    public function a_job_has_tags()
    {
        $job = create('App\Job');
        create('App\Tag', ['job_id' => $job->id], 4);

        $this->assertInstanceOf('App\Tag', $job->tags->first());
    }

    /** @test */
    public function a_job_can_save_tags()
    {
        $job = create('App\Job');
        $tags = ['foo', 'bar', 'bat'];

        $job->saveTags($tags);

        $this->assertTrue($job->tags->contains('tag', 'foo'));
        $this->assertTrue($job->tags->contains('tag', 'bar'));
        $this->assertTrue($job->tags->contains('tag', 'bat'));
    }
}
