<?php

class EducationFieldValidationTest extends TestCase
{
    /**
     * Path to create new education
     *
     * @var string
     */
    private $path;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
        $this->path = '/profile/education?token=' . loginWorker()->user->token;
    }

    /** @test */
    public function an_education_requires_a_name()
    {
        $education = raw('App\Education', ['name' => null]);

        $this->post($this->path, $education)
            ->assertContains('The name field is required.', $this->response->content());
    }

    /** @test */
    public function an_education_requires_a_level()
    {
        $education = raw('App\Education', ['level' => null]);

        $this->post($this->path, $education)
            ->assertContains('The level field is required.', $this->response->content());
    }

    /** @test */
    public function an_education_requires_a_grade()
    {
        $education = raw('App\Education', ['grade' => null]);

        $this->post($this->path, $education)
            ->assertContains('The grade field is required.', $this->response->content());
    }

    /** @test */
    public function an_education_requires_an_institution()
    {
        $education = raw('App\Education', ['institution' => null]);

        $this->post($this->path, $education)
            ->assertContains('The institution field is required.', $this->response->content());
    }

    /** @test */
    public function an_education_requires_a_completion_date()
    {
        $education = raw('App\Education', ['completion_date' => null]);

        $this->post($this->path, $education)
            ->assertContains('The completion date field is required.', $this->response->content());
    }
}
