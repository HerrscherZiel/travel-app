<?php

namespace App\Http\Controllers;

use App\Models\JadwalTravel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\PemesananTiket;
use App\Models\LaporanTravel;



class JadwalTravelController extends Controller
{
    public function getJadwalTravel()
    {
        $jadwal = JadwalTravel::all(); // Ambil semua data
        return response()->json(['data' => $jadwal]);
    }

    public function getAvailableJadwal()
    {
        $jadwal = JadwalTravel::whereDate('tanggal_jam', '>=', now())
            ->orderBy('tanggal_jam', 'asc')
            ->get()
            ->map(function ($item) {
                $jumlah_pemesanan = PemesananTiket::where('jadwal_travel_id', $item->id)
                ->count();
                $item->sisa_kuota = max($item->kuota - $jumlah_pemesanan, 0);
                return $item;
            });
    
        return response()->json(['data' => $jadwal]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required|string|max:255',
            'tanggal_jam' => 'required|date',
            'kuota' => 'required|integer|min:1',
            'harga_tiket' => 'required|numeric|min:0',
        ]);

        $jadwal = JadwalTravel::create([
            'tujuan' => $request->tujuan,
            'tanggal_jam' => $request->tanggal_jam,
            'kuota' => $request->kuota,
            'harga_tiket' => $request->harga_tiket,
        ]);

        LaporanTravel::create([
            'jadwal_travel_id' => $jadwal->id,
            'jumlah_penumpang' => 0, // Awalnya 0 karena belum ada pemesan
        ]);

        return response()->json(['message' => 'Jadwal travel berhasil ditambahkan', 'jadwal' => $jadwal], 201);
    }
    
    public function show($id)
    {
        $jadwal = JadwalTravel::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }
        return response()->json(['data' => $jadwal]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalTravel::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'tujuan' => 'required|string|max:255',
            'tanggal_jam' => 'required|date',
            'kuota' => 'required|integer|min:1',
            'harga_tiket' => 'required|numeric|min:0',
        ]);

        $jadwal->update($validated);

        return response()->json(['message' => 'Jadwal berhasil diperbarui', 'data' => $jadwal]);
    }
    
    public function destroy($id)
    {
        $jadwal = JadwalTravel::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }


}