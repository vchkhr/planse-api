<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_api()
    {
        $response = $this->get('/api/test');

        $response->assertStatus(200);
    }
}
