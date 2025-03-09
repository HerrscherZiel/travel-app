<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalTravel;
use App\Models\PemesananTiket;
use App\Models\Pembayaran;
use App\Models\LaporanTravel;

class PembayaranController extends Controller
{
    //
    public function getPendingPayments(Request $request)
    {
        $user = $request->user(); // Ambil user dari token
        $pembayaran = Pembayaran::with('pemesanan.jadwalTravel')
                    ->where('user_id', $user->id)
                    ->where('status_bayar', 'pending')
                    ->get();
    
        return response()->json(['data' => $pembayaran]);
    }
    
    

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
        ]);
    
        $pembayaran = Pembayaran::where('id', $id)->where('status_bayar', 'pending')->first();
    
        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan atau sudah diproses'], 404);
        }
    
        // Upload file ke storage
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public'); 
    
            $pembayaran->bukti_pembayaran = $path;
            $pembayaran->status_bayar = 'success';
            $pembayaran->waktu_pembayaran = now();
            $pembayaran->save();
    
            // Ubah status pembayaran di pemesanan
            if ($pembayaran && $pembayaran->pemesanan) {
                $pembayaran->pemesanan->update(['status_pembayaran' => 'lunas']);
            
                $jadwal_id = $pembayaran->pemesanan->jadwal_travel_id;
            
                if ($jadwal_id) {
                    LaporanTravel::where('jadwal_travel_id', $jadwal_id)->increment('jumlah_penumpang');
                }
            } else {
                return response()->json(['message' => 'Data pembayaran atau pemesanan tidak ditemukan'], 404);
            }
            
    
            return response()->json(['message' => 'Bukti pembayaran berhasil diunggah', 'data' => $pembayaran]);
        }
    
        return response()->json(['message' => 'Gagal mengunggah bukti pembayaran'], 400);
    }
    
    
}
