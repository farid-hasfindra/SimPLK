@extends('layouts.client_app')

@section('title', 'Dashboard Pelanggan')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pelanggan</h1>
        <a href="{{ route('pelanggan.booking') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Booking Baru
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

    <div class="row">
        <!-- Hewan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Hewan Peliharaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $hewans->count() }} Ekor</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Upcoming Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Booking Akan Datang</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingBookings->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Hewan Peliharaan</h6>
                </div>
                <div class="card-body">
                    @if($hewans->isEmpty())
                        <p class="text-center">Belum ada data hewan.</p>
                    @else
                        <ul class="list-group">
                            @foreach($hewans as $hewan)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $hewan->nama_hewan }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $hewan->jenis_hewan }} - {{ $hewan->ras }}</small>
                                    </div>
                                    <span class="badge badge-info badge-pill">{{ \Carbon\Carbon::parse($hewan->tanggal_lahir)->age }} Tahun</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Booking Terdekat</h6>
                </div>
                <div class="card-body">
                    @if($upcomingBookings->isEmpty())
                        <p class="text-center">Tidak ada booking mendatang.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Hewan</th>
                                        <th>Dokter</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingBookings as $booking)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</td>
                                            <td>{{ $booking->hewan->nama_hewan }}</td>
                                            <td>{{ $booking->jadwalPraktek->dokter->user->name }}</td>
                                            <td>
                                                @if($booking->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($booking->status == 'confirmed')
                                                    <span class="badge badge-primary">Confirmed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
