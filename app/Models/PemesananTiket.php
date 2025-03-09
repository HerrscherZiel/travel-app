<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananTiket extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_tiket';

    protected $fillable = [
        'user_id',
        'jadwal_travel_id',
        'tanggal_pemesanan',
        'status_pembayaran',
    ];

    /**
     * Relasi ke tabel User (pemesan tiket).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel JadwalTravel.
     */
    public function jadwalTravel()
    {
        return $this->belongsTo(JadwalTravel::class, 'jadwal_travel_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pemesanan_id');
    }

}

