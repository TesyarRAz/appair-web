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
        ->orWhere(fn($query) => $query
            ->whereNot('status', ['lunas', 'lewati'])
        )
        ->latest();
    }

    public function latestTransaksi()
    {
        return $this->hasOne(Transaksi::class)->ofMany('tanggal_tempo')
        ->whereIn('status', ['lunas', 'lewati']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
