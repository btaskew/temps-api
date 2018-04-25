<?php

class AuthenticationTest extends TestCase
{
    /** @test */
    public function can_signup_a_new_staff_user()
    {
        $user = raw('App\User');

        $this->post('/signup/staff', $user)
            ->seeInDatabase('users', [
                'name' => $user['name'],
                'email' => $user['email']
            ])
            ->seeInDatabase('staff', [
                // We know this will be 1 as it's the only user
                'user_id' => 1
            ]);

        $this->assertContains('token', $this->response->content());
    }

    /** @test */
    public function can_signup_a_new_worker_user()
    {
        $user = raw('App\User');

        $this->post('/signup/worker', $user)
            ->seeInDatabase('users', [
                'name' => $user['name'],
                'email' => $user['email']
            ])
            ->seeInDatabase('workers', [
                // We know this will be 1 as it's the only user
                'user_id' => 1
            ]);

        $this->assertContains('token', $this->response->content());
    }

    /** @test */
    public function signing_up_a_new_user_also_logs_them_in()
    {
        $user = raw('App\User');

        $this->post('/signup/worker', $user)
            ->seeInDatabase('active_users', [
                // We know this will be 1 as it's the only user
                'user_id' => 1
            ]);
    }

    /** @test */
    public function cant_sign_up_a_new_user_with_the_same_email()
    {
        $this->withExceptionHandling();

        $existingUser = create('App\User');

        $newUser = raw('App\User', ['email' => $existingUser->email]);

        $this->post('/signup/worker', $newUser)
            ->assertResponseStatus(409);

        $this->assertContains("User already exists with email $existingUser->email", $this->response->content());
    }


    /** @test */
    public function can_login_a_new_user()
    {
        $user = create('App\User', [
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);

        $this->post('/login', [
                'email' => $user->email,
                'password' => 'password'
            ])
            ->seeInDatabase('active_users', [
                'user_id' => $user->id
            ]);

        $this->assertContains('token', $this->response->content());
    }

    /** @test */
    public function throws_exception_when_logging_in_with_wrong_password()
    {
        $this->withExceptionHandling();

        $user = create('App\User', ['password' => 'foo']);

        $this->post('/login', [
                'email' => $user->email,
                'password' => 'bar'
            ])
            ->assertResponseStatus(401);

        $this->assertContains('Invalid credentials', $this->response->content());
    }

    /** @test */
    public function throws_exception_when_logging_in_with_wrong_email()
    {
        $this->withExceptionHandling();

        $user = create('App\User', ['email' => 'foo@email.com']);

        $this->post('/login', [
                'email' => 'bar@email.com',
                'password' => $user->password
            ])
            ->assertResponseStatus(404);
    }

    /** @test */
    public function can_logout_an_active_user()
    {
        $user = create('App\User')->setActive()->user;

        $this->post('/logout', ['email' => $user->email])
            ->notSeeInDatabase('active_users', [
                'user_id' => $user->id
            ]);

        $this->assertContains('success', $this->response->content());
    }
}
