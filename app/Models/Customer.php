<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'rt' => 'integer',
        'is_all_lunas' => 'boolean',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function activeTransaksi()
    {
        return $this->currentTransaksi()
        ->whereNotIn('status', ['lunas', 'lewati']);
    }

    public function currentTransaksi()
    {
        return $this->hasOne(Transaksi::class)->ofMany()
        ->whereMonth('tanggal_tempo', now())
        ->whereYear('tanggal_tempo', now());
    }

    public function latestTransaksi()
    {
        return $this->hasOne(Transaksi::class)->ofMany()
        ->when($this->currentTransaksi, fn($query) => $query
            ->whereNotIn(app(Transaksi::class)->getKeyName(), [$this->currentTransaksi->id])
        );
    }

    public function getLastMeterAttribute()
    {
        return (int) (optional($this->latestTransaksi)->meteran_akhir ?? $this->meteran_pertama);
    }

    public function getIsAllLunasAttribute()
    {
        return !$this->transaksis()->whereIn('status', ['belum_bayar'])->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
