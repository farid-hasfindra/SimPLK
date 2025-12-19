@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Status Booking</h1>
        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Detail Booking</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th>No Antrean</th>
                            <td>: <span class="badge badge-info" style="font-size: 1.2em;">{{ $booking->no_antrean }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Dokter</th>
                            <td>: {{ $booking->jadwalPraktek->dokter->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Pasien</th>
                            <td>: {{ $booking->hewan->nama_hewan }} ({{ $booking->hewan->jenis_hewan }})</td>
                        </tr>
                        <tr>
                            <th>Pemilik</th>
                            <td>: {{ $booking->hewan->pelanggan->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Keluhan</th>
                            <td>: {{ $booking->keluhan_awal }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="status">Update Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed (Disetujui)</option>
                        <option value="selesai" {{ $booking->status == 'selesai' ? 'selected' : '' }}>Selesai (Pemeriksaan Beres)</option>
                        <option value="batal" {{ $booking->status == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
