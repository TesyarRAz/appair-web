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
        if ($request->type == 'active')
        {
            $now_transaksi = auth()->user()->customer->activeTransaksi;

            return response()->json([
                'status' => 'success',
                'data' => $now_transaksi,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => auth()->user()->customer->transaksis()->whereIn('status', ['lunas', 'lewati'])->latest()->cursorPaginate(10),
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
