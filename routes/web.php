<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');



Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::view('/login', 'auth.login')->name('login');


Route::get('/dashboard', function () {
    return view('auth.dashboard');
})->name('dashboard');

Route::get('/admin/users', function () {
    return view('admin.user.index');
})->name('users');

Route::get('/admin/jadwal', function () {
    return view('admin.jadwal_travel.index');
})->name('admin.jadwal');

Route::get('/admin/laporan-travel', function () {
    return view('admin.laporan_travel.index');
})->name('admin.laporan');



Route::get('/pengguna/jadwal-travel', function () {
    return view('pengguna.jadwal_travel.index');
})->name('jadwal.travel.pengguna');

Route::get('/pengguna/pemesanan', function () {
    return view('pengguna.pemesanan.index');
})->name('pemesanan.tiket');

Route::get('/pengguna/riwayat-pemesanan', function () {
    return view('pengguna.pemesanan.riwayat');
})->name('pemesanan.riwayat');

Route::get('/pembayaran/pending', function () {
    return view('pengguna.pembayaran.index');
})->name('pembayaran.index');







Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
