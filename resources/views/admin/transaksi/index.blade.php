@extends('layouts.app')

@section('title', 'Data Transaksi / Kasir')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi & Pembayaran</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tagihan-tab" data-toggle="tab" href="#tagihan" role="tab" aria-controls="tagihan" aria-selected="true">Tagihan Belum Dibayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="riwayat-tab" data-toggle="tab" href="#riwayat" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat Transaksi</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <!-- Tab Tagihan -->
                <div class="tab-pane fade show active" id="tagihan" role="tabpanel" aria-labelledby="tagihan-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableTagihan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Periksa</th>
                                    <th>No. RM</th>
                                    <th>Pasien (Hewan)</th>
                                    <th>Pemilik</th>
                                    <th>Total Tagihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($belumBayar as $rm)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d M Y H:i') }}</td>
                                        <td>RM-{{ $rm->id }}</td>
                                        <td>{{ $rm->booking->hewan->nama_hewan }}</td>
                                        <td>{{ $rm->booking->hewan->pelanggan->user->name }}</td>
                                        <td>Rp {{ number_format($rm->total_biaya, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('admin.transaksi.create', ['rekam_medis_id' => $rm->id]) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-money-bill-wave"></i> Bayar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Riwayat -->
                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableRiwayat" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Bayar</th>
                                    <th>No. RM</th>
                                    <th>Pasien</th>
                                    <th>Total Bayar</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $trx)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d M Y H:i') }}</td>
                                        <td>RM-{{ $trx->rekam_medis_id }}</td>
                                        <td>{{ $trx->rekamMedis->booking->hewan->nama_hewan }}</td>
                                        <td>Rp {{ number_format($trx->total_biaya_akhir, 0, ',', '.') }}</td>
                                        <td>{{ $trx->metode_bayar }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ ucfirst($trx->status_bayar) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.transaksi.show', $trx->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-print"></i> Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTableTagihan').DataTable();
        $('#dataTableRiwayat').DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
</script>
@endpush
