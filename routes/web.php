<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\JadwalPraktekController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('barang', BarangController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('hewan', HewanController::class);
    Route::resource('jadwal', JadwalPraktekController::class);
    Route::resource('booking', BookingController::class);
    Route::resource('rekam-medis', RekamMedisController::class);
    Route::resource('transaksi', TransaksiController::class);
});

Route::prefix('dokter')->name('dokter.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dokter'])->name('dashboard');
});


Route::prefix('pelanggan')->name('pelanggan.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/jadwal', [ClientController::class, 'jadwal'])->name('jadwal');
    Route::get('/booking', [ClientController::class, 'bookingForm'])->name('booking');
    Route::post('/booking', [ClientController::class, 'bookingStore'])->name('booking.store');
    Route::get('/riwayat', [ClientController::class, 'riwayat'])->name('riwayat');
    Route::post('/hewan', [ClientController::class, 'storeHewan'])->name('hewan.store');

    // Profile Management
    Route::get('/profile', [ClientController::class, 'profile'])->name('profile');
    Route::put('/profile', [ClientController::class, 'profileUpdate'])->name('profile.update');
});

