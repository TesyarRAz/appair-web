<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Transaksi;
use App\Settings\PriceSetting;
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
        $tanggal_tempo = now()->endOfMonth();

        $customers = Customer::with('latestTransaksi')->whereDoesntHave('activeTransaksi')->where('active', true)->get();

        $customers->each(fn($customer) => $customer->transaksis()->create([
            'tanggal_tempo' => $tanggal_tempo,
            'status' => 'belum_bayar',
            'meteran_awal' => $customer->latestTransaksi->meteran_akhir,
            'meteran_akhir' => 0,
        ]));
    }
}
