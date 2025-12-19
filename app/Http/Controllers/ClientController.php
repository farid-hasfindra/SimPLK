<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalPraktek;
use App\Models\Booking;
use App\Models\Hewan;
use App\Models\RekamMedis;
use App\Models\Transaksi;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $hewans = Hewan::where('pelanggan_id', $pelanggan->id)->get();

        $upcomingBooking = Booking::whereHas('hewan', function ($q) use ($pelanggan) {
            $q->where('pelanggan_id', $pelanggan->id);
        })
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'batal')
            ->with(['jadwalPraktek.dokter.user', 'hewan'])
            ->orderBy('tanggal_booking', 'asc')
            ->first();

        // 1. Tagihan Belum Lunas
        $unpaidTransactions = Transaksi::whereHas('rekamMedis.booking.hewan', function ($q) use ($pelanggan) {
            $q->where('pelanggan_id', $pelanggan->id);
        })->where('status_bayar', 'pending')->count();

        // 2. Riwayat Medis Terakhir
        $lastVisit = RekamMedis::whereHas('booking.hewan', function ($q) use ($pelanggan) {
            $q->where('pelanggan_id', $pelanggan->id);
        })->with(['booking.hewan', 'booking.jadwalPraktek.dokter.user'])->latest('tanggal_periksa')->first();

        // 3. Dokter Hari Ini
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        $todayName = $days[\Carbon\Carbon::now()->format('l')];

        $doctorsToday = JadwalPraktek::where('hari', $todayName)
            ->where('status', 'aktif')
            ->with('dokter.user')
            ->get();

        return view('client.dashboard', compact('hewans', 'upcomingBooking', 'pelanggan', 'user', 'unpaidTransactions', 'lastVisit', 'doctorsToday'));
    }

    public function jadwal()
    {
        $jadwals = JadwalPraktek::with('dokter.user')->get();
        return view('client.jadwal', compact('jadwals'));
    }

    public function bookingForm()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        $hewans = Hewan::where('pelanggan_id', $pelanggan->id)->get();
        $jadwals = JadwalPraktek::with('dokter.user')->get();

        return view('client.booking', compact('hewans', 'jadwals'));
    }

    public function bookingStore(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewan,id',
            'jadwal_id' => 'required|exists:jadwal_praktek,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan_awal' => 'required|string',
        ]);

        // Ambil jadwal + dokter
        $jadwal = JadwalPraktek::with('dokter')->findOrFail($request->jadwal_id);
        $namaDokter = $jadwal->dokter->nama;

        // Ambil inisial dokter (Sarhan Pratama → SP)
        $inisial = collect(explode(' ', $namaDokter))
            ->map(fn($kata) => strtoupper(substr($kata, 0, 1)))
            ->implode('');

        // Hitung antrean HARI INI untuk dokter tsb
        $count = Booking::where('jadwal_id', $request->jadwal_id)
            ->whereDate('tanggal_booking', $request->tanggal_booking)
            ->count();

        $nomorUrut = $count + 1;

        // Format nomor (01, 02, dst)
        $kodeAntrean = $inisial . str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);

        Booking::create([
            'hewan_id' => $request->hewan_id,
            'jadwal_id' => $request->jadwal_id,
            'user_id' => Auth::id(),
            'tanggal_booking' => $request->tanggal_booking,
            'no_antrean' => $kodeAntrean,
            'keluhan_awal' => $request->keluhan_awal,
            'status' => 'pending',
        ]);

        return redirect()->route('pelanggan.dashboard')
            ->with('success', "Booking berhasil! Nomor antrean Anda: $kodeAntrean");
    }

    public function riwayat()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        $bookings = Booking::whereHas('hewan', function ($q) use ($pelanggan) {
            $q->where('pelanggan_id', $pelanggan->id);
        })
            ->with(['jadwalPraktek.dokter.user', 'hewan', 'rekamMedis'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.riwayat', compact('bookings'));
    }
    public function storeHewan(Request $request)
    {
        $request->validate([
            'nama_hewan' => 'required|string|max:255',
            'jenis_hewan' => 'required|string|max:50',
            'ras' => 'nullable|string|max:100',
            'umur' => 'nullable|integer',
            'berat_badan' => 'nullable|numeric',
            'catatan_kesehatan' => 'nullable|string',
        ]);

        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        Hewan::create([
            'pelanggan_id' => $pelanggan->id,
            'nama_hewan' => $request->nama_hewan,
            'jenis_hewan' => $request->jenis_hewan,
            'ras' => $request->ras,
            'umur' => $request->umur,
            'berat_badan' => $request->berat_badan,
            'catatan_kesehatan' => $request->catatan_kesehatan,
        ]);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Data hewan berhasil ditambahkan.');
    }

    public function profile()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;
        return view('client.profile', compact('user', 'pelanggan'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        // Update User Account
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Update Customer Data
        if ($pelanggan) {
            $pelanggan->alamat = $request->alamat;
            $pelanggan->no_hp = $request->no_hp;
            $pelanggan->save();
        } else {
            // Create if not exists (edge case)
            $user->pelanggan()->create([
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);
        }

        return redirect()->route('pelanggan.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
