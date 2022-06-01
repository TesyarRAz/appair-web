<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NormalizeTool implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $customers = Customer::whereDoesntHave('transaksis', fn($query) => $query
            ->whereMonth('tanggal_bayar', now())->whereYear('tanggal_bayar', now())
        )->get();

        $customers->each(fn($customer) => $customer->transaksis()->create([
            'tanggal_bayar' => now(),
            'total_harga' => 0,
            'status' => 'lewati',
        ]));
    }
}
