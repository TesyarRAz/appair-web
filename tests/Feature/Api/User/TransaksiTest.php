<?php

namespace Tests\Feature\Api\User;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    use WithFaker;

    public function test_index()
    {
        $response = $this->customer()->get('/api/user/transaksi');

        $response->assertStatus(200);
    }

    public function test_non_lunas()
    {
        $response = $this->customer()->get('/api/user/transaksi?type=check_now');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => null,
            ]);
    }

    public function test_lunas()
    {
        $user = User::factory()->customer()->create();

        $customer = $user->customer;

        Transaksi::factory()->create([
            'customer_id' => $customer->id,
            'lunas' => true,
        ]);

        $response = $this->actingAs($user)->get('/api/user/transaksi?type=check_now');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonMissing([
                'data' => null,
            ]);
    }

    public function test_bayar_success()
    {
        $user = User::factory()->customer()->create();

        $customer = $user->customer;

        Transaksi::factory()->create([
            'customer_id' => $customer->id,
            'lunas' => false,
        ]);

        $response = $this->actingAs($user)->post('/api/user/transaksi', [
            'bukti_bayar' => $this->faker->image('public/storage/bukti_bayar'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);
    }

    public function test_bayar_failed()
    {
        $user = User::factory()->customer()->create();

        $customer = $user->customer;

        Transaksi::factory()->create([
            'customer_id' => $customer->id,
            'lunas' => true,
        ]);

        $response = $this->actingAs($user)->post('/api/user/transaksi', [
            'bukti_bayar' => $this->faker->image('public/storage/bukti_bayar'),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'failed',

            ]);
    }
}
