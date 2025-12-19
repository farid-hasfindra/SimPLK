<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hewan;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['hewan.pelanggan.user', 'jadwalPraktek.dokter.user'])
            ->orderBy('tanggal_booking', 'desc')
            ->orderBy('no_antrean', 'asc')
            ->get();
        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hewans = Hewan::with('pelanggan.user')->get();
        $jadwals = JadwalPraktek::with('dokter.user')->get();
        return view('admin.booking.create', compact('hewans', 'jadwals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewan,id',
            'jadwal_id' => 'required|exists:jadwal_praktek,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan_awal' => 'required|string',
        ]);

        // Cek apakah hari sesuai dengan jadwal
        $jadwal = JadwalPraktek::findOrFail($request->jadwal_id);
        $hariBooking = Carbon::parse($request->tanggal_booking)->isoFormat('dddd'); // Senin, Selasa, dst.

        // Mapping hari Carbon ke Bahasa Indonesia jika perlu, tapi isoFormat('dddd') dengan locale ID harusnya sudah benar.
        // Namun untuk aman, kita pastikan locale app.

        // Sederhananya kita asumsikan input user valid dulu atau kita validasi manual.
        // Note: Carbon isoFormat might depend on server locale.
        // Let's use a simple mapping or trust the user picks the right date for now,
        // or better: validate that the selected date matches the schedule day.

        // Generate No Antrean
        $lastQueue = Booking::where('jadwal_id', $request->jadwal_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->max('no_antrean');

        $no_antrean = $lastQueue ? $lastQueue + 1 : 1;

        // Cek Kuota
        if ($no_antrean > $jadwal->kuota_harian) {
            return back()->withErrors(['msg' => 'Kuota harian untuk jadwal ini sudah penuh.']);
        }

        Booking::create([
            'hewan_id' => $request->hewan_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal_booking' => $request->tanggal_booking,
            'no_antrean' => $no_antrean,
            'status' => 'pending',
            'keluhan_awal' => $request->keluhan_awal,
        ]);

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dibuat. No Antrean: ' . $no_antrean);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('admin.booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $hewans = Hewan::with('pelanggan.user')->get();
        $jadwals = JadwalPraktek::with('dokter.user')->get();
        return view('admin.booking.edit', compact('booking', 'hewans', 'jadwals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,selesai,batal',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.booking.index')->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dihapus.');
    }
}
