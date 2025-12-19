@extends('layouts.app')

@section('title', 'Input Rekam Medis')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Rekam Medis</h1>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Data Pasien</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="150">Nama Hewan</td>
                            <td>: {{ $booking->hewan->nama_hewan }} ({{ $booking->hewan->jenis_hewan }})</td>
                        </tr>
                        <tr>
                            <td>Pemilik</td>
                            <td>: {{ $booking->hewan->pelanggan->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Keluhan Awal</td>
                            <td>: {{ $booking->keluhan_awal }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Data Dokter</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="150">Nama Dokter</td>
                            <td>: {{ $booking->jadwalPraktek->dokter->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Spesialisasi</td>
                            <td>: {{ $booking->jadwalPraktek->dokter->spesialisasi }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <form action="{{ route('admin.rekam-medis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <div class="form-group">
                    <label for="tanggal_periksa">Tanggal & Jam Periksa</label>
                    <input type="datetime-local" class="form-control" id="tanggal_periksa" name="tanggal_periksa" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="form-group">
                    <label for="diagnosa">Diagnosa</label>
                    <textarea class="form-control" id="diagnosa" name="diagnosa" rows="3" required>{{ old('diagnosa') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tindakan">Tindakan</label>
                    <textarea class="form-control" id="tindakan" name="tindakan" rows="3" required>{{ old('tindakan') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="biaya_tindakan">Biaya Jasa / Tindakan (Rp)</label>
                    <input type="number" class="form-control" id="biaya_tindakan" name="biaya_tindakan" value="{{ old('biaya_tindakan', intval($booking->jadwalPraktek->dokter->tarif_dasar)) }}" min="0" required>
                </div>

                <div class="form-group">
                    <label for="catatan_dokter">Catatan Tambahan</label>
                    <textarea class="form-control" id="catatan_dokter" name="catatan_dokter" rows="2">{{ old('catatan_dokter') }}</textarea>
                </div>

                <hr>
                <h5 class="mb-3">Resep Obat / Penggunaan Barang</h5>

                <div id="obat-container">
                    <div class="row obat-row mb-2">
                        <div class="col-md-6">
                            <select class="form-control" name="obat_id[]">
                                <option value="">-- Pilih Obat/Barang --</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_satuan }}">
                                        {{ $barang->nama_barang }} (Stok: {{ $barang->stok }}) - Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" name="jumlah_obat[]" placeholder="Jumlah" min="1">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-remove-obat"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-success btn-sm mb-4" id="btn-add-obat">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Simpan Rekam Medis & Selesaikan Pemeriksaan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Add Obat Row
        $('#btn-add-obat').click(function() {
            var row = $('.obat-row').first().clone();
            row.find('input').val('');
            row.find('select').val('');
            $('#obat-container').append(row);
        });

        // Remove Obat Row
        $(document).on('click', '.btn-remove-obat', function() {
            if ($('.obat-row').length > 1) {
                $(this).closest('.obat-row').remove();
            } else {
                alert('Minimal satu baris obat harus ada (kosongkan jika tidak ada obat).');
            }
        });
    });
</script>
@endpush
