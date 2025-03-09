<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalTravelController;
use App\Http\Controllers\PemesananTicketController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanTravelController;



Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        \Log::info($request->user()); // Debugging log
        return response()->json($request->user()); // Pastikan mengembalikan JSON
    });
});



Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/jadwal-travel', [JadwalTravelController::class, 'getJadwalTravel']); // Get all
    Route::post('/jadwal-travel', [JadwalTravelController::class, 'store']); // Create
    Route::get('/jadwal-travel/{id}', [JadwalTravelController::class, 'show']); // Get single
    Route::put('/jadwal-travel/{id}', [JadwalTravelController::class, 'update']); // Update
    Route::delete('/jadwal-travel/{id}', [JadwalTravelController::class, 'destroy']); // Delete
});

Route::middleware(['auth:sanctum'])->get('admin/users', [UserController::class, 'getUsers']);

Route::get('/jadwal-travel/available', [JadwalTravelController::class, 'getAvailableJadwal']);
Route::middleware('auth:sanctum')->get('/pemesanan-tiket', [PemesananTicketController::class, 'index']);
Route::middleware('auth:sanctum')->post('/pemesanan-tiket', [PemesananTicketController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/pemesanan-tiket/{id}', [PemesananTicketController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/pemesanan-tiket/riwayat', [PemesananTicketController::class, 'riwayatPemesanan']);

Route::middleware('auth:sanctum')->get('/pembayaran/pending', [PembayaranController::class, 'getPendingPayments']);
Route::middleware('auth:sanctum')->post('/pembayaran/upload/{id}', [PembayaranController::class, 'uploadBuktiPembayaran']);


Route::middleware('auth:sanctum')->get('/admin/laporan-travel/users/{jadwal_id}', [LaporanTravelController::class, 'getUsersByJadwal']);
Route::middleware('auth:sanctum')->get('/laporan-travel', [LaporanTravelController::class, 'index']);







// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return response()->json($request->user());
// });


