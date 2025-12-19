<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalPasien = User::where('role', 'pelanggan')->count();
        $totalDokter = User::where('role', 'dokter')->count();
        $bookingHariIni = Booking::whereDate('tanggal_booking', Carbon::today())->count();

        $pendapatanBulanIni = Transaksi::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_biaya_akhir');

        $stokMenipis = Barang::where('stok', '<=', 10)->limit(5)->get();

        $bookingTerbaru = Booking::with(['hewan.pelanggan.user', 'jadwalPraktek.dokter.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('index', [
            'title' => 'Admin Dashboard',
            'totalPasien' => $totalPasien,
            'totalDokter' => $totalDokter,
            'bookingHariIni' => $bookingHariIni,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'stokMenipis' => $stokMenipis,
            'bookingTerbaru' => $bookingTerbaru
        ]);
    }

    public function dokter()
    {
        return view('index', ['title' => 'Dokter Dashboard']);
    }

    public function pelanggan()
    {
        return view('index', ['title' => 'Pelanggan Dashboard']);
    }
}
