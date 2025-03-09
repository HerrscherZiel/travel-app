<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanTravel;
use App\Models\JadwalTravel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
class LaporanTravelController extends Controller
{
    //
    public function index()
    {
        // Ambil semua data laporan travel beserta jadwal travel terkait
        $laporan = LaporanTravel::with('jadwalTravel')->get();

        return response()->json(['data' => $laporan], 200);
    }

    public function getUsersByJadwal($jadwal_id)
    {
        // Ambil pemesanan dengan jadwal_travel_id tertentu dan status pembayaran "lunas"
        $users = User::whereHas('pemesanan', function ($query) use ($jadwal_id) {
            $query->where('jadwal_travel_id', $jadwal_id)
                ->where('status_pembayaran', 'lunas');
        })->get(['id', 'uname', 'email']);

        return response()->json(['data' => $users]);
    }

}
