@extends('layouts.app')

@section('title', 'Detail Rekam Medis')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Rekam Medis</h1>
        <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">No. Rekam Medis: {{ $rekamMedis->id }}</h6>
            <span class="badge badge-success">{{ optional($rekamMedis->tanggal_periksa)->format('d M Y H:i') ?? '-' }}</span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2">Informasi Pasien</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="150">Nama Hewan</td>
                            <td>: {{ $rekamMedis->booking->hewan->nama_hewan }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Hewan</td>
                            <td>: {{ $rekamMedis->booking->hewan->jenis_hewan }}</td>
                        </tr>
                        <tr>
                            <td>Pemilik</td>
                            <td>: {{ $rekamMedis->booking->hewan->pelanggan->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Keluhan Awal</td>
                            <td>: {{ $rekamMedis->booking->keluhan_awal }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2">Informasi Dokter</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="150">Nama Dokter</td>
                            <td>: {{ $rekamMedis->booking->jadwalPraktek->dokter->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Spesialisasi</td>
                            <td>: {{ $rekamMedis->booking->jadwalPraktek->dokter->spesialisasi }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2">Hasil Pemeriksaan</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="200" class="bg-light">Diagnosa</th>
                            <td>{{ $rekamMedis->diagnosa }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Tindakan</th>
                            <td>{{ $rekamMedis->tindakan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Catatan Dokter</th>
                            <td>{{ $rekamMedis->catatan_dokter ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5 class="font-weight-bold text-dark border-bottom pb-2">Resep Obat / Penggunaan Barang</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat/Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis->detailResep as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->barang->nama_barang }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada resep obat.</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Total Biaya Obat</td>
                                    <td class="font-weight-bold">Rp {{ number_format($rekamMedis->detailResep->sum('sub_total'), 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right font-weight-bold">Biaya Tindakan</td>
                                    <td class="font-weight-bold">Rp {{ number_format($rekamMedis->biaya_tindakan, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="4" class="text-right font-weight-bold h5">Total Akhir</td>
                                    <td class="font-weight-bold h5 text-primary">Rp {{ number_format($rekamMedis->total_biaya, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
