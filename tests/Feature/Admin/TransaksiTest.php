<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    public function test_index()
    {
        $this->admin()->get('/admin/transaksi')
        ->assertStatus(200);
    }

    public function test_store_must_failed()
    {
        $user = User::factory()->customer()->create();

        $this->admin()->post('/admin/transaksi', [
            'id_customer' => $user->customer->id,
        ]);
    }
}
