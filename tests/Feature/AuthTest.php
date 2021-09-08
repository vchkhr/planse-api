<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_anuthorized()
    {
        $response = $this->get('/api/login');

        $response->assertStatus(401);
    }

    public function test_register()
    {
        $response = $this->get('/api/login');

        $response->assertStatus(401);
    }
}
