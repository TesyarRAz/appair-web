<?php

namespace App\Http\Requests\Api\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class BayarRequest extends FormRequest
{
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
            'bukti_bayar' => 'required|file|image',
            'kuantitas' => 'required|numeric|min:1',
        ];
    }

    public function getNowTransaksi()
    {
        return auth()->user()->customer->activeTransaksi;
    }
}
