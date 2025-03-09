<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'jumlah_pembayaran',
        'status_bayar',
        'waktu_pembayaran',
        'bukti_pembayaran'
    ];

    protected $casts = [
        'waktu_pembayaran' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(PemesananTiket::class, 'pemesanan_id');
    }
}
