<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Transaksi\BayarRequest;
use App\Jobs\UploadFile;
use App\Models\Transaksi;
use App\Settings\PriceSetting;
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

        return response()->json(
            auth()->user()->customer->transaksis()->whereIn('status', ['lunas', 'lewati'])->latest()->cursorPaginate(10),
        );
    }

    public function bayar(BayarRequest $request)
    {
        $now_transaksi = $request->getNowTransaksi();

        $price = resolve(PriceSetting::class);

        if (filled($now_transaksi) && !in_array($now_transaksi->status, ['lunas', 'lewati']))
        {
            $now_transaksi->update([
                'bukti_bayar' => UploadFile::dispatchSync($request->file('bukti_bayar'), 'images/bukti_bayar'),
                'total_harga' => $request->kuantitas * $price->per_kubik,
                'status' => 'diterima',
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
