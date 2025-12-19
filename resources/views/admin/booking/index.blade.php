@extends('layouts.app')

@section('title', 'Data Booking')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Booking</h1>
        <a href="{{ route('admin.booking.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            Tambah Booking
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Booking Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Antrean</th>
                            <th>Pasien (Hewan)</th>
                            <th>Pemilik</th>
                            <th>Dokter</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</td>
                                <td><span class="badge badge-info badge-counter" style="font-size: 1em;">{{ $booking->no_antrean }}</span></td>
                                <td>{{ $booking->hewan->nama_hewan }} ({{ $booking->hewan->jenis_hewan }})</td>
                                <td>{{ $booking->hewan->pelanggan->user->name }}</td>
                                <td>{{ $booking->jadwalPraktek->dokter->user->name }}</td>
                                <td>
                                    @if($booking->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="badge badge-primary">Confirmed</span>
                                    @elseif($booking->status == 'selesai')
                                        <span class="badge badge-success">Selesai</span>
                                    @else
                                        <span class="badge badge-danger">Batal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->status == 'confirmed')
                                        <a href="{{ route('admin.rekam-medis.create', ['booking_id' => $booking->id]) }}" class="btn btn-success btn-sm" title="Periksa / Rekam Medis">
                                            <i class="fas fa-stethoscope"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.booking.edit', $booking->id) }}" class="btn btn-info btn-sm" title="Ubah Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "order": [[ 1, "desc" ]] // Sort by date descending
        });
    });
</script>
@endpush
