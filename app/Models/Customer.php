<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function activeTransaksi()
    {
        return $this->hasOne(Transaksi::class)->ofMany()
        ->whereMonth('tanggal_tempo', now())
        ->whereYear('tanggal_tempo', now())
        ->whereNot('status', ['lunas', 'lewati']);
    }

    public function latestTransaksi()
    {
        return $this->hasOne(Transaksi::class)
        ->whereIn('status', ['lunas', 'lewati']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
