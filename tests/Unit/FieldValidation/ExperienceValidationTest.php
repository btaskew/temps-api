<?php

class ExperienceValidationTest extends TestCase
{
    /**
     * Path to create new experience
     *
     * @var string
     */
    private $path;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
        $this->path = '/profile/experience?token=' . setActiveWorker()->user->activeUser->token;
    }

    /** @test */
    public function an_experience_requires_a_title()
    {
        $experience = raw('App\Experience', ['title' => null]);

        $this->post($this->path, $experience)
            ->assertContains('The title field is required.', $this->response->content());
    }

    /** @test */
    public function an_experience_requires_a_description()
    {
        $experience = raw('App\Experience', ['description' => null]);

        $this->post($this->path, $experience)
            ->assertContains('The description field is required.', $this->response->content());
    }

    /** @test */
    public function an_experience_requires_a_type()
    {
        $experience = raw('App\Experience', ['type' => null]);

        $this->post($this->path, $experience)
            ->assertContains('The type field is required.', $this->response->content());
    }

    /** @test */
    public function an_experience_requires_a_valid_type()
    {
        $experience = raw('App\Experience', ['type' => 'foobar']);

        $this->post($this->path, $experience)
            ->assertContains('The selected type is invalid.', $this->response->content());
    }

    /** @test */
    public function an_experience_requires_a_start_date()
    {
        $experience = raw('App\Experience', ['start_date' => null]);

        $this->post($this->path, $experience)
            ->assertContains('The start date field is required.', $this->response->content());
    }
}
