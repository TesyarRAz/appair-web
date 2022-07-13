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

        if ($request->type == 'latest')
        {
            $latest_transaksi = auth()->user()->customer->latestTransaksi;

            return response()->json([
                'status' => 'success',
                'data' => $latest_transaksi,
            ]);
        }

        return response()->json(
            auth()->user()->customer->transaksis()->whereIn('status', ['lunas', 'lewati'])->latest()->cursorPaginate(10),
        );
    }

    public function bayar(BayarRequest $request)
    {
        $now_transaksi = $request->getNowTransaksi();
        $before_transaksi = $now_transaksi->beforeThis();

        $price = resolve(PriceSetting::class);

        if (blank($now_transaksi) || !in_array($now_transaksi->status, ['lunas', 'lewati']))
        {
            abort_if(blank($before_transaksi) || $before_transaksi->meteran_akhir < $before_transaksi->meteran_awal, 403, "Meteran awal tidak mungkin lebih dari meteran akhir");

            $data = [
                'bukti_bayar' => UploadFile::dispatchSync($request->file('bukti_bayar'), 'images/bukti_bayar'),
                'meteran_awal' => $before_transaksi->meteran_akhir,
                'meteran_akhir' => $request->meteran_akhir,
                'total_harga' => ($before_transaksi->meteran_akhir - $request->meteran_akhir) * $price->per_kubik,
                'status' => 'diterima',
            ];

            if (filled($now_transaksi))
            {
                $now_transaksi->update($data);
            }
            else
            {
                auth()->user()->customer->transaksis()->create($data + [
                    'tanggal_tempo' => now()->endOfMonth(),
                ]);
            }

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
