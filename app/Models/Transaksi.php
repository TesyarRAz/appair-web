<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'lunas' => 'boolean',
        'tanggal_bayar' => 'date:Y-m-d',
        'tanggal_tempo' => 'date:Y-m-d',
        'meteran_awal' => 'integer',
        'meteran_akhir' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($transaksi) {
            $transaksi->kode = 'TRX-' . str()->padLeft(static::max('id') + 1, 8, '0');
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function beforeThis()
    {
        return Transaksi::latest('tanggal_tempo')
        ->whereDate('tanggal_tempo', '<', $this->tanggal_tempo)
        ->whereNot('id', $this->id)
        ->first();
    }
}
