@extends('layouts.app')

@section('title', 'Data Hewan')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Hewan</h1>
        <a href="{{ route('admin.hewan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            Tambah Hewan
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Hewan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pemilik</th>
                            <th>Nama Hewan</th>
                            <th>Jenis</th>
                            <th>Ras</th>
                            <th>Umur (Tahun)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hewans as $hewan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $hewan->pelanggan->user->name ?? '-' }}</td>
                                <td>{{ $hewan->nama_hewan }}</td>
                                <td>{{ $hewan->jenis_hewan }}</td>
                                <td>{{ $hewan->ras ?? '-' }}</td>
                                <td>{{ $hewan->tanggal_lahir ? \Carbon\Carbon::parse($hewan->tanggal_lahir)->age : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.hewan.edit', $hewan->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.hewan.destroy', $hewan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
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
            }
        });
    });
</script>
@endpush
