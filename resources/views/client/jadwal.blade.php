@extends('layouts.client_app')

@section('title', 'Jadwal Dokter')

@section('content')
    <div class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-up">
            <h5 class="font-weight-bold text-dark mb-0">Jadwal Praktek</h5>
            <span class="badge badge-pill badge-light shadow-sm px-3 py-2 text-muted">{{ $jadwals->count() }} Dokter</span>
        </div>

        <div class="animate-fade-up delay-100">
            @foreach ($jadwals as $index => $jadwal)
                <div class="card mb-3 animate-fade-up" style="animation-delay: {{ 100 + ($index * 100) }}ms;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="mr-3 position-relative">
                                    <div class="bg-light rounded-circle p-3 d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-user-md fa-lg text-primary"></i>
                                    </div>
                                    @if($jadwal->status == 'aktif')
                                        <span class="position-absolute bg-success border border-white rounded-circle"
                                            style="width: 12px; height: 12px; bottom: 2px; right: 2px;"></span>
                                    @else
                                        <span class="position-absolute bg-secondary border border-white rounded-circle"
                                            style="width: 12px; height: 12px; bottom: 2px; right: 2px;"></span>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="font-weight-bold mb-0 text-dark">{{ $jadwal->dokter->user->name }}</h6>
                                    <small class="text-muted d-block">{{ $jadwal->dokter->spesialisasi }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge badge-light text-dark px-2 mb-1 border">
                                    <i class="far fa-calendar-alt mr-1 text-muted"></i> {{ $jadwal->hari }}
                                </span>
                                <div class="small font-weight-bold text-dark ml-1">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                </div>
                            </div>

                            @if ($jadwal->status == 'aktif')
                                <a href="{{ route('pelanggan.booking', ['jadwal_id' => $jadwal->id]) }}"
                                    class="btn btn-primary px-4 shadow-sm btn-sm rounded-pill">
                                    Booking
                                </a>
                            @else
                                <button class="btn btn-light px-4 btn-sm rounded-pill text-muted" disabled>Libur</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if($jadwals->isEmpty())
                <div class="text-center py-5 text-muted animate-fade-up">
                    <i class="far fa-calendar-times fa-3x mb-3 text-gray-300"></i>
                    <p>Belum ada jadwal praktek tersedia.</p>
                </div>
            @endif
        </div>
    </div>
@endsection