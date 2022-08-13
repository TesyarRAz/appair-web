<?php

namespace App\Http\Requests\Admin\Transaksi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'tanggal_bayar' => 'required|date',
            'tanggal_tempo' => 'required|date',
            'total_bayar' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'status' => 'required|in:belum_bayar,diterima,lewati,ditolak,lunas',
            'bukti_bayar' => 'file|image',
            'meteran_awal' => 'required|numeric',
            'meteran_akhir' => 'required|numeric',
            'keterangan_ditolak' => 'bail',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'admin_id' => auth()->id(),
            'total_harga' => str($this->total_harga)->replace('.', '')->value(),
            'total_bayar' => str($this->total_harga)->replace('.', '')->value(),
        ]);
    }
}
