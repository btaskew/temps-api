<?php

class UserFieldValidationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->withExceptionHandling();
    }

    /** @test */
    public function a_signup_requires_a_name()
    {
        $user = raw('App\User', ['name' => null]);

        $this->post('/signup/worker', $user)
            ->assertContains('The name field is required.', $this->response->content());
    }

    /** @test */
    public function a_signup_requires_an_email()
    {
        $user = raw('App\User', ['email' => null]);

        $this->post('/signup/worker', $user)
            ->assertContains('The email field is required.', $this->response->content());
    }

    /** @test */
    public function a_signup_requires_an_password()
    {
        $user = raw('App\User', ['password' => null]);

        $this->post('/signup/worker', $user)
            ->assertContains('The password field is required.', $this->response->content());
    }

    /** @test */
    public function a_login_requires_an_email()
    {
        $this->post('/login', ['password' => 'password'])
            ->assertContains('The email field is required.', $this->response->content());
    }

    /** @test */
    public function a_login_requires_a_password()
    {
        $this->post('/login', ['email' => 'email@email.com'])
            ->assertContains('The password field is required.', $this->response->content());
    }

    /** @test */
    public function a_logout_requires_an_email()
    {
        $this->post('/logout')
            ->assertContains('The email field is required.', $this->response->content());
    }
}
