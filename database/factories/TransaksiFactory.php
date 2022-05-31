<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = $this->faker->randomElement('diterima', 'ditolak', 'lewati', 'lunas');
        return [
            'customer_id' => User::factory()->customer()->create()->customer->id,
            'status' => $status,
            'keterangan_ditolak' => $status == 'ditolak' ? $this->faker->sentence : null,
            'tanggal_bayar' => now(),
        ];
    }
}
