<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_home()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_login()
    {
        $this->get('/login')->assertStatus(200);

        $response = $this->post('/login', [
            'username_or_email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }

    public function test_logout()
    {
        $this->admin()->get('/logout')
        ->assertStatus(302)
        ->assertRedirect('/login');
    }
}
