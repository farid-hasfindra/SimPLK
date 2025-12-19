<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil Rekam Medis yang belum dibayar (belum ada di tabel transaksi)
        $belumBayar = RekamMedis::doesntHave('transaksi')
            ->with(['booking.hewan.pelanggan.user', 'booking.jadwalPraktek.dokter.user'])
            ->get();

        // Ambil Transaksi yang sudah ada (Riwayat)
        $riwayat = Transaksi::with(['rekamMedis.booking.hewan.pelanggan.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transaksi.index', compact('belumBayar', 'riwayat'));
    }

    /**
     * Show the form for creating a new resource.
     * Kita gunakan ini sebagai form pembayaran
     */
    public function create(Request $request)
    {
        $rekamMedisId = $request->query('rekam_medis_id');

        if (!$rekamMedisId) {
            return redirect()->route('admin.transaksi.index')->with('error', 'Pilih tagihan terlebih dahulu.');
        }

        $rekamMedis = RekamMedis::with(['booking.hewan.pelanggan.user', 'detailResep.barang'])
            ->findOrFail($rekamMedisId);

        // Cek jika sudah dibayar
        if ($rekamMedis->transaksi) {
            return redirect()->route('admin.transaksi.show', $rekamMedis->transaksi->id);
        }

        return view('admin.transaksi.create', compact('rekamMedis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id|unique:transaksi,rekam_medis_id',
            'total_biaya_akhir' => 'required|numeric',
            'metode_bayar' => 'required|string',
            'bayar' => 'required|numeric|gte:total_biaya_akhir', // Uang yang dibayarkan user
        ]);

        $transaksi = Transaksi::create([
            'rekam_medis_id' => $request->rekam_medis_id,
            'total_biaya_akhir' => $request->total_biaya_akhir,
            'metode_bayar' => $request->metode_bayar,
            'status_bayar' => 'lunas',
            'tanggal_bayar' => Carbon::now(),
        ]);

        // Kita bisa simpan kembalian di session flash jika perlu, atau handle di view show
        $kembalian = $request->bayar - $request->total_biaya_akhir;

        return redirect()->route('admin.transaksi.show', $transaksi->id)
            ->with('success', 'Pembayaran berhasil! Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with(['rekamMedis.booking.hewan.pelanggan.user', 'rekamMedis.detailResep.barang', 'rekamMedis.booking.jadwalPraktek.dokter.user'])
            ->findOrFail($id);

        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}
