<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalTravel;
use App\Models\PemesananTiket;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class PemesananTicketController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
    
        if (!$userId) {
            return response()->json(['message' => 'User ID diperlukan'], 400);
        }
    
        $pemesanan = PemesananTiket::with(['jadwalTravel'])
                                    ->where('user_id', $userId)
                                    ->where('status_pembayaran', 'pending')
                                    ->orderBy('tanggal_pemesanan', 'desc')
                                    ->get();
    
        return response()->json(['data' => $pemesanan]);
    }
    
    public function riwayatPemesanan(Request $request)
    {
        $userId = $request->query('user_id'); // Ambil dari query
        if (!$userId) {
            return response()->json(['message' => 'User ID diperlukan'], 400);
        }

        $pemesanan = PemesananTiket::with(['jadwalTravel'])
                                    ->where('user_id', $userId)
                                    ->where('status_pembayaran', 'lunas')
                                    ->orderBy('tanggal_pemesanan', 'desc')
                                    ->get();

        return response()->json(['data' => $pemesanan]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'jadwal_travel_id' => 'required|exists:jadwal_travel,id',
        ]);

        $user = Auth::user(); // Pastikan pengguna sudah login dengan Sanctum

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $jadwal = JadwalTravel::findOrFail($request->jadwal_travel_id);


        // Simpan data pemesanan
        $pemesanan = PemesananTiket::create([
            'user_id' => $user->id,
            'jadwal_travel_id' => $request->jadwal_travel_id,
            'tanggal_pemesanan' => now(),
            'status_pembayaran' => 'pending'
        ]);

        Pembayaran::create([
            'user_id' => $user->id,
            'pemesanan_id' => $pemesanan->id,
            'jumlah_pembayaran' => $pemesanan->jadwalTravel->harga_tiket,
            'status_bayar' => 'pending',
            'waktu_pembayaran' => null,
            'bukti_pembayaran' => null
        ]);

        return response()->json(['message' => 'Pemesanan berhasil', 'data' => $pemesanan]);
    }

    public function destroy($id)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Cari pemesanan berdasarkan ID dan user yang login
        $pemesanan = PemesananTiket::where('id', $id)
                                ->where('user_id', $user->id) // Pastikan hanya pemilik pemesanan yang bisa hapus
                                ->where('status_pembayaran', 'pending') // Hanya boleh hapus jika masih pending
                                ->first();

        if (!$pemesanan) {
            return response()->json(['message' => 'Pemesanan tidak ditemukan atau tidak bisa dibatalkan'], 404);
        }

        $pemesanan->delete(); // Hapus pemesanan

        return response()->json(['message' => 'Pemesanan tiket berhasil dibatalkan']);
    }
}