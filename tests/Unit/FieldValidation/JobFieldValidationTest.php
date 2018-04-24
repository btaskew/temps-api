<?php

class JobFieldValidationTest extends TestCase
{
    /**
     * Active user's login token
     *
     * @var string
     */
    private $token;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
        $this->token = setActiveStaff()->user->activeUser->token;
    }

    /** @test */
    public function a_job_requires_a_title()
    {
        $job = raw('App\Job', ['title' => null, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The title field is required.", $this->response->content());
    }

    /** @test */
    public function a_job_requires_a_description()
    {
        $job = raw('App\Job', ['description' => null, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The description field is required.", $this->response->content());
    }

    /** @test */
    public function a_job_requires_tags()
    {
        $job = raw('App\Job');

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The tags field is required.", $this->response->content());
    }

    /** @test */
    public function a_job_requires_a_closing_date()
    {
        $job = raw('App\Job', ['closing_date' => null, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The closing date field is required.", $this->response->content());
    }

    /** @test */
    public function a_job_requires_an_open_vacancies_value()
    {
        $job = raw('App\Job', ['open_vacancies' => null, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The open vacancies field is required.", $this->response->content());
    }

    /** @test */
    public function a_jobs_open_vacancies_must_be_more_than_0()
    {
        $job = raw('App\Job', ['open_vacancies' => 0, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The open vacancies must be at least 1.", $this->response->content());
    }

    /** @test */
    public function a_job_requires_a_duration()
    {
        $job = raw('App\Job', ['duration' => null, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The duration field is required.", $this->response->content());
    }

    /** @test */
    public function a_jobs_duration_must_be_more_than_zero_point_five()
    {
        $job = raw('App\Job', ['duration' => 0.3, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The duration must be at least 0.5.", $this->response->content());
    }

    /** @test */
    public function a_job_requires_a_rate()
    {
        $job = raw('App\Job', ['rate' => null, 'tags' => ['foo']]);

        $this->post('/jobs?token=' . $this->token, $job)
            ->assertContains("The rate field is required.", $this->response->content());
    }
}