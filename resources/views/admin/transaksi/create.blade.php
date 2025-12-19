@extends('layouts.app')

@section('title', 'Proses Pembayaran')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Proses Pembayaran</h1>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Tagihan (No. RM: {{ $rekamMedis->id }})</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Pasien:</strong> {{ $rekamMedis->booking->hewan->nama_hewan }} <br>
                            <strong>Pemilik:</strong> {{ $rekamMedis->booking->hewan->pelanggan->user->name }}
                        </div>
                        <div class="col-md-6 text-right">
                            <strong>Tanggal Periksa:</strong> <br>
                            {{ \Carbon\Carbon::parse($rekamMedis->tanggal_periksa)->format('d M Y H:i') }}
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Deskripsi</th>
                                <th class="text-right">Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jasa Dokter / Tindakan ({{ $rekamMedis->tindakan }})</td>
                                <td class="text-right">Rp {{ number_format($rekamMedis->biaya_tindakan, 0, ',', '.') }}</td>
                            </tr>
                            @foreach($rekamMedis->detailResep as $detail)
                                <tr>
                                    <td>{{ $detail->barang->nama_barang }} ({{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_ini, 0, ',', '.') }})</td>
                                    <td class="text-right">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="font-weight-bold bg-light">
                                <td>Total Tagihan</td>
                                <td class="text-right text-primary h5">Rp {{ number_format($rekamMedis->total_biaya, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Pembayaran</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transaksi.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="rekam_medis_id" value="{{ $rekamMedis->id }}">
                        <input type="hidden" name="total_biaya_akhir" value="{{ $rekamMedis->total_biaya }}">

                        <div class="form-group">
                            <label for="total_tagihan_display">Total Tagihan</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($rekamMedis->total_biaya, 0, ',', '.') }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="metode_bayar">Metode Pembayaran</label>
                            <select class="form-control" name="metode_bayar" required>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Debit Card">Debit Card</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="bayar">Jumlah Bayar (Rp)</label>
                            <input type="number" class="form-control" id="bayar" name="bayar" min="{{ $rekamMedis->total_biaya }}" required placeholder="Masukkan nominal">
                            <small id="kembalianText" class="form-text text-muted mt-2 font-weight-bold">Kembalian: Rp 0</small>
                        </div>

                        <button type="submit" class="btn btn-success btn-block btn-lg mt-4">
                            <i class="fas fa-check-circle"></i> Proses Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var totalTagihan = {{ $rekamMedis->total_biaya }};

        $('#bayar').on('input', function() {
            var bayar = $(this).val();
            var kembalian = bayar - totalTagihan;

            if (kembalian >= 0) {
                $('#kembalianText').text('Kembalian: Rp ' + new Intl.NumberFormat('id-ID').format(kembalian));
                $('#kembalianText').removeClass('text-danger').addClass('text-success');
            } else {
                $('#kembalianText').text('Kurang: Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(kembalian)));
                $('#kembalianText').removeClass('text-success').addClass('text-danger');
            }
        });
    });
</script>
@endpush
