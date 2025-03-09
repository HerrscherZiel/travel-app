<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTravel extends Model
{
    use HasFactory;

    protected $table = 'laporan_penumpang'; // Nama tabel di database

    protected $fillable = [
        'jadwal_travel_id',
        'jumlah_penumpang',
    ];

    // Relasi ke model JadwalTravel
    public function jadwalTravel()
    {
        return $this->belongsTo(JadwalTravel::class, 'jadwal_travel_id');
    }
}
