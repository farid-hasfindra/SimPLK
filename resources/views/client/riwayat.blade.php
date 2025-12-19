@extends('layouts.client_app')

@section('title', 'Riwayat')

@section('content')
<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-up">
        <h5 class="font-weight-bold text-dark mb-0">Riwayat Kunjungan</h5>
        <div class="bg-white rounded-pill shadow-sm px-3 py-2">
            <i class="fas fa-filter text-primary small"></i>
            <span class="small text-muted font-weight-bold ml-1">Terbaru</span>
        </div>
    </div>

    @if($bookings->isEmpty())
        <div class="text-center py-5 text-muted animate-fade-up delay-100">
            <div class="mb-3 opacity-50">
                <i class="fas fa-history fa-4x text-gray-300"></i>
            </div>
            <h6 class="font-weight-bold">Belum ada riwayat</h6>
            <p class="small">Riwayat pemeriksaan hewan Anda akan muncul di sini.</p>
        </div>
    @else
        <div class="timeline animate-fade-up delay-100">
            @foreach($bookings as $index => $booking)
                <div class="timeline-item mb-4 animate-fade-up" style="animation-delay: {{ 100 + ($index * 100) }}ms;">
                    <div class="date-label text-muted small font-weight-bold mb-2 ml-1">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}
                    </div>
                    
                    <div class="card shadow-sm border-0 position-relative overflow-hidden">
                        <!-- Status Strip -->
                        <div class="status-strip {{ 
                            $booking->status == 'selesai' ? 'bg-success' : 
                            ($booking->status == 'dibatalkan' ? 'bg-danger' : 
                            ($booking->status == 'dikonfirmasi' ? 'bg-primary' : 'bg-warning')) 
                        }}"></div>

                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="font-weight-bold mb-1 text-dark">{{ $booking->hewan->nama_hewan }}</h5>
                                    <span class="badge badge-light border">{{ $booking->hewan->jenis_hewan }}</span>
                                </div>
                                <div class="text-right">
                                    @if($booking->status == 'selesai')
                                        <span class="badge badge-success-soft text-success px-3 py-1 rounded-pill small font-weight-bold">Selesai</span>
                                    @elseif($booking->status == 'dibatalkan')
                                        <span class="badge badge-danger-soft text-danger px-3 py-1 rounded-pill small font-weight-bold">Batal</span>
                                    @elseif($booking->status == 'dikonfirmasi')
                                        <span class="badge badge-primary-soft text-primary px-3 py-1 rounded-pill small font-weight-bold">Dikonfirmasi</span>
                                    @else
                                        <span class="badge badge-warning-soft text-warning px-3 py-1 rounded-pill small font-weight-bold">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block mb-1 font-weight-bold">DOKTER</small>
                                    <div class="d-flex align-items-center">
                                         <i class="fas fa-user-md text-primary mr-2 small"></i>
                                         <span class="small font-weight-bold text-dark">{{ $booking->jadwalPraktek->dokter->user->name }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block mb-1 font-weight-bold">KELUHAN</small>
                                    <p class="small text-dark mb-0 text-truncate" style="max-width: 150px;">
                                        {{ $booking->keluhan_awal }}
                                    </p>
                                </div>
                            </div>

                            @if($booking->rekamMedis)
                                <div class="bg-light rounded p-3 mt-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-file-medical text-success mr-2"></i>
                                        <h6 class="font-weight-bold mb-0 text-success small">HASIL PEMERIKSAAN</h6>
                                    </div>
                                    
                                    <div class="row small">
                                        <div class="col-12 mb-2">
                                            <span class="text-muted">Diagnosa:</span>
                                            <span class="font-weight-bold text-dark d-block">{{ $booking->rekamMedis->diagnosa }}</span>
                                        </div>
                                        <div class="col-12">
                                            <span class="text-muted">Tindakan:</span>
                                            <span class="text-dark d-block">{{ $booking->rekamMedis->tindakan }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .status-strip {
        position: absolute;
        top: 0; 
        left: 0;
        bottom: 0;
        width: 6px;
    }
    .badge-success-soft { background-color: #d1e7dd; }
    .badge-danger-soft { background-color: #f8d7da; }
    .badge-warning-soft { background-color: #fff3cd; }
    .badge-primary-soft { background-color: #cfe2ff; }
    
    .timeline-item { position: relative; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -15px;
        top: 35px;
        bottom: -20px;
        width: 2px;
        background-color: #e9ecef;
        display: none; /* Hidden for now, cleaner look without vertical line for cards */
    }
</style>
@endsection
