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
            'total_bayar' => 'required|numeric',
            'status' => 'required|in:diterima,lewati,ditolak,lunas',
            'bukti_bayar' => 'file|image',
        ];
    }

    protected function passedValidation()
    {
        if ($this->hasFile('bukti_bayar')) {
            $this->merge([
                'bukti_bayar' => Storage::disk('public')->putFile('images/bukti_bayar', $this->file('bukti_bayar')),
           ]);
        }
    }
}
