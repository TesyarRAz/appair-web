<?php

namespace App\Http\Requests\Api\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class BayarRequest extends FormRequest
{
    private $now_transaksi;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return filled($this->getNowTransaksi());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function getNowTransaksi()
    {
        return $now_transaksi = auth()->user()->customer->transaksis()
            ->whereMonth('tanggal_bayar', now())
            ->whereYear('tanggal_bayar', now())
            ->where('status', 'lunas')
            ->first();
    }
}
