<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Transaksi\BayarRequest;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 'check_now')
        {
            $now_transaksi = auth()->user()->customer->transaksis()
            ->whereMonth('tanggal_bayar', now())
            ->whereYear('tanggal_bayar', now())
            ->first();

            return response()->json([
                'status' => 'success',
                'data' => $now_transaksi,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->customer->transaksis()->latest()->limit(3)->get(),
        ]);
    }

    public function bayar(BayarRequest $request)
    {
        $now_transaksi = $request->getNowTransaksi();

        if (filled($now_transaksi))
        {
            $now_transaksi->update([
                'bukti_bayar' => $request->bukti_bayar->store('bukti_bayar', 'public'),
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $now_transaksi,
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => null,
        ]);
    }
}
