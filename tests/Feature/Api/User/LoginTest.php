<?php

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login()
    {
        $this->assertDatabaseHas('users', [
            'username' => 'test',
            'email' => 'test@example.com',
        ]);

        $response = $this->post('/api/login', [
            'username_or_email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }
}
