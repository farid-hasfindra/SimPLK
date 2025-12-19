<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Booking;
use App\Models\Barang;
use App\Models\DetailResep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekamMedis = RekamMedis::with(['booking.hewan.pelanggan.user', 'booking.jadwalPraktek.dokter.user'])->get();
        return view('admin.rekam_medis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $booking_id = $request->query('booking_id');
        $booking = null;

        if ($booking_id) {
            $booking = Booking::with(['hewan.pelanggan.user', 'jadwalPraktek.dokter.user'])->find($booking_id);
        }

        // Jika tidak ada booking_id atau booking tidak ditemukan, mungkin kita bisa tampilkan list booking yang confirmed?
        // Untuk simplifikasi, kita asumsikan user masuk dari halaman Booking -> Klik "Periksa"

        $barangs = Barang::where('stok', '>', 0)->get(); // Untuk resep obat

        return view('admin.rekam_medis.create', compact('booking', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'tanggal_periksa' => 'required|date',
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'biaya_tindakan' => 'required|numeric|min:0',
            'catatan_dokter' => 'nullable|string',
            'obat_id' => 'array',
            'obat_id.*' => 'exists:barang,id',
            'jumlah_obat' => 'array',
            'jumlah_obat.*' => 'integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Rekam Medis
            $rekamMedis = RekamMedis::create([
                'booking_id' => $request->booking_id,
                'tanggal_periksa' => $request->tanggal_periksa,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'biaya_tindakan' => $request->biaya_tindakan,
                'catatan_dokter' => $request->catatan_dokter,
            ]);

            // 2. Update Status Booking jadi 'selesai'
            $booking = Booking::find($request->booking_id);
            $booking->update(['status' => 'selesai']);

            // 3. Simpan Detail Resep (Jika ada obat)
            if ($request->has('obat_id')) {
                foreach ($request->obat_id as $key => $barangId) {
                    $jumlah = $request->jumlah_obat[$key];
                    $barang = Barang::find($barangId);

                    if ($barang && $barang->stok >= $jumlah) {
                        $subTotal = $barang->harga_satuan * $jumlah;

                        DetailResep::create([
                            'rekam_medis_id' => $rekamMedis->id,
                            'barang_id' => $barangId,
                            'jumlah' => $jumlah,
                            'harga_saat_ini' => $barang->harga_satuan,
                            'sub_total' => $subTotal,
                        ]);

                        // Kurangi Stok Barang
                        $barang->decrement('stok', $jumlah);
                    }
                }
            }
        });

        return redirect()->route('admin.rekam-medis.index')->with('success', 'Rekam Medis berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['booking.hewan.pelanggan.user', 'booking.jadwalPraktek.dokter.user', 'detailResep.barang'])->findOrFail($id);

        // dd($rekamMedis);
        return view('admin.rekam_medis.show', compact('rekamMedis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekamMedis $rekamMedis)
    {
        // Implementasi edit jika diperlukan (biasanya rekam medis jarang diedit kecuali typo)
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        // Hapus rekam medis akan mengembalikan stok?
        // Untuk simplifikasi, kita anggap hapus rekam medis = hapus data saja, stok tidak kembali otomatis (perlu logic tambahan).
        // Tapi karena cascade delete, detail resep akan hilang.

        $rekamMedis->delete();
        return redirect()->route('admin.rekam-medis.index')->with('success', 'Rekam Medis berhasil dihapus.');
    }
}
