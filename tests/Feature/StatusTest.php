<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusTest extends TestCase
{
    /**
     * Root should redirect to login page
     *
     * @return void
     */
    public function test_root()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /**
     * Admin should redirect to login page
     *
     * @return void
     */
    public function test_admin()
    {
        $response = $this->get('/admin');

        $response->assertStatus(302);
    }

    public function test_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}
