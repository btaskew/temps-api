<?php

class ResponseFieldValidationTest extends TestCase
{
    /**
     * Path to respond to the application
     *
     * @var string
     */
    private $path;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();

        $staff = setActiveStaff();
        $job = create('App\Job', ['staff_id' => $staff->id]);
        $application = create('App\Application', ['job_id' => $job->id]);
        $this->path = "/jobs/$job->id/applications/$application->id/respond?token=" .
            $staff->user->activeUser->token;
    }

    /** @test */
    public function an_application_response_requires_a_type()
    {
        $response = raw('App\ApplicationResponse', ['type' => null]);

        $this->post($this->path, $response)
            ->assertContains('The type field is required.', $this->response->content());
    }

    /** @test */
    public function an_application_responses_type_must_be_valid()
    {
        $response = raw('App\ApplicationResponse', ['type' => 'foo']);

        $this->post($this->path, $response)
            ->assertContains('The selected type is invalid.', $this->response->content());
    }

    /** @test */
    public function an_application_response_requires_a_comment()
    {
        $response = raw('App\ApplicationResponse', ['comment' => null]);

        $this->post($this->path, $response)
            ->assertContains('The comment field is required.', $this->response->content());
    }

    /** @test */
    public function an_application_response_requires_a_reject_all_value()
    {
        $response = raw('App\ApplicationResponse', ['reject_all' => null]);

        $this->post($this->path, $response)
            ->assertContains('The reject all field is required.', $this->response->content());
    }
}