<?php

namespace Tests\Feature\Admin;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function test_index()
    {
        $this->admin()
            ->get('/admin/customer')
            ->assertStatus(200);
    }

    public function test_store()
    {
        $data = User::factory()->make()->toArray();

        unset($data['email_verified_at']);

        $data['password'] = 'password';

        $this->admin()
            ->post('/admin/customer', $data)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', $data);
        $this->assertDatabaseHas('customers', [
            'user_id' => User::where('username', $data['username'])->first()->id,
        ]);
    }

    public function test_update()
    {
        $user = User::factory()->customer()->create();

        $data = User::factory()->make()->toArray();

        unset($data['email_verified_at']);

        $data['password'] = 'password';

        $this->admin()
            ->put('/admin/customer/' . $user->customer->id, $data)
            ->assertRedirect('/admin/customer')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', $data);
    }

    public function test_delete()
    {
        $user = User::factory()->customer()->create();

        $this->admin()
            ->delete('/admin/customer/' . $user->customer->id)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
        
        $this->assertDatabaseMissing('customers', [
            'user_id' => $user->id,
        ]);
    }
}
