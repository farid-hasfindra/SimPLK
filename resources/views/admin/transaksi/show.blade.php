@extends('layouts.app')

@section('title', 'Invoice Pembayaran')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Invoice Pembayaran</h1>
        <div>
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm shadow-sm ml-2">
                <i class="fas fa-print"></i> Cetak Invoice
            </button>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-5">
            <div class="row mb-4">
                <div class="col-6">
                    <h4 class="font-weight-bold text-primary">SimPLK - Klinik Hewan</h4>
                    <p>Jl. Contoh No. 123, Kota Contoh<br>Telp: 0812-3456-7890</p>
                </div>
                <div class="col-6 text-right">
                    <h4 class="font-weight-bold">INVOICE</h4>
                    <p>No. Invoice: INV-{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}<br>
                    Tanggal: {{ \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d M Y H:i') }}</p>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-6">
                    <h6 class="font-weight-bold">Ditagihkan Kepada:</h6>
                    <p>
                        <strong>{{ $transaksi->rekamMedis->booking->hewan->pelanggan->user->name }}</strong><br>
                        {{ $transaksi->rekamMedis->booking->hewan->pelanggan->alamat }}<br>
                        HP: {{ $transaksi->rekamMedis->booking->hewan->pelanggan->no_hp }}
                    </p>
                </div>
                <div class="col-6 text-right">
                    <h6 class="font-weight-bold">Pasien:</h6>
                    <p>
                        {{ $transaksi->rekamMedis->booking->hewan->nama_hewan }}
                        ({{ $transaksi->rekamMedis->booking->hewan->jenis_hewan }})
                    </p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Deskripsi</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Jasa Dokter -->
                        <tr>
                            <td>Jasa Dokter / Tindakan ({{ $transaksi->rekamMedis->tindakan }})</td>
                            <td class="text-right">Rp {{ number_format($transaksi->rekamMedis->biaya_tindakan, 0, ',', '.') }}</td>
                            <td class="text-center">1</td>
                            <td class="text-right">Rp {{ number_format($transaksi->rekamMedis->biaya_tindakan, 0, ',', '.') }}</td>
                        </tr>

                        <!-- Obat -->
                        @foreach($transaksi->rekamMedis->detailResep as $detail)
                            <tr>
                                <td>{{ $detail->barang->nama_barang }}</td>
                                <td class="text-right">Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-right">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" class="text-right font-weight-bold">Total Tagihan</td>
                            <td class="text-right font-weight-bold">Rp {{ number_format($transaksi->total_biaya_akhir, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <p class="font-weight-bold">Metode Pembayaran: <span class="badge badge-info">{{ $transaksi->metode_bayar }}</span></p>
                    <p class="font-weight-bold">Status: <span class="badge badge-success">{{ strtoupper($transaksi->status_bayar) }}</span></p>
                </div>
                <div class="col-md-6 text-right">
                    <p>Terima kasih atas kepercayaan Anda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .sidebar, .topbar, footer {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        body {
            background-color: white !important;
        }
    }
</style>
@endpush
