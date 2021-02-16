<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Login with credentials: user@test.com / 12345678 should redirect to admin
     *
     * @return void
     */
    public function test_login_success()
    {
        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => '12345678'
        ]);

        $response->assertRedirect('/admin');
    }

    /**
     * Login with credentials: user@test.com / 1234567 should fail
     *
     * @return void
     */
    public function test_login_fail()
    {
        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => '1234567'
        ]);
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }

    /**
     * Login with blank credentials
     *
     * @return void
     */
    public function test_login_blank()
    {
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.'
        ]);
    }
}
