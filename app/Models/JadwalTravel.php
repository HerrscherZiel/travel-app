<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalTravel extends Model
{
    use HasFactory;

    protected $table = 'jadwal_travel';

    protected $fillable = [
        'tujuan',
        'tanggal_jam',
        'kuota',
        'harga_tiket',
    ];

    public function pemesanan()
    {
        return $this->hasMany(PemesananTiket::class, 'jadwal_travel_id');
    }

    public function laporanTravel()
    {
        return $this->has(LaporanTravel::class, 'jadwal_travel_id');
    }
}
