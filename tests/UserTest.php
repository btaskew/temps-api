<?php

class UserTest extends TestCase
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
}
