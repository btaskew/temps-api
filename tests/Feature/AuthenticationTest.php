<?php

class AuthenticationTest extends TestCase
{
    /** @test */
    public function can_signup_a_new_user()
    {
        $user = [
            'name' => 'Test user',
            'email' => 'test@email.com',
            'password' => 'password'
        ];

        $this->post('/signup', $user)
            ->seeInDatabase('users', [
                'name' => 'Test user',
                'email' => 'test@email.com'
            ]);
    }

    /** @test */
    public function signing_up_a_new_user_also_logs_them_in()
    {
        $user = [
            'name' => 'Test user',
            'email' => 'test@email.com',
            'password' => 'password'
        ];

        $this->post('/signup', $user)
            ->seeInDatabase('active_users', [
                // We know this will be 1 as it's the only user
                'user_id' => '1'
            ]);
    }

    /** @test */
    public function a_signup_requires_an_email()
    {
        $userNoEmail = [
            'name' => 'Test user',
            'password' => 'password'
        ];

        $this->post('/signup', $userNoEmail)
            ->assertResponseStatus(422);
    }

    /** @test */
    public function cant_sign_up_a_new_user_with_the_same_email()
    {
        $existingUser = factory('App\User')->create();

        $newUser = [
            'name' => 'Test user',
            'email' => $existingUser->email,
            'password' => 'password'
        ];

        $this->post('/signup', $newUser)
            ->assertResponseStatus(422);
    }


    /** @test */
    public function can_login_a_new_user()
    {
        $user = factory('App\User')->create([
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);

        $this->post('/login', [
                'email' => $user->email,
                'password' => 'password'
            ])
            ->seeInDatabase('active_users', [
                'user_id' => $user->id
            ]);
    }

    /** @test */
    public function throws_exception_when_logging_in_with_wrong_password()
    {
        $user = factory('App\User')->create([
            'password' => 'foo'
        ]);

        $this->post('/login', [
                'email' => $user->email,
                'password' => 'bar'
            ])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function throws_exception_when_logging_in_with_wrong_email()
    {
        $user = factory('App\User')->create([
            'email' => 'foo@email.com'
        ]);

        $this->post('/login', [
                'email' => 'bar@email.com',
                'password' => $user->password
            ])
            ->assertResponseStatus(404);
    }

    /** @test */
    public function can_logout_an_active_user()
    {
        $user = factory('App\User')->create();
        $user->setActive();

        $this->post('/logout', ['email' => $user->email])
            ->notSeeInDatabase('active_users', [
                'user_id' => $user->id
            ]);
    }
}
