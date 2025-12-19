@extends('layouts.client_app')
@section('title', 'Dashboard - Animalia Clinic')

@section('content')
    <div class="container pb-5">

        <!-- Decorative Blob (Red/Gold) -->
        <div class="blob-bg"></div>

        <!-- Banner -->
        <div class="card bg-gradient-primary text-white mb-4 animate-pop p-1">
            <div class="card-body position-relative overflow-hidden p-4">
                <div class="position-absolute"
                    style="right: -20px; top: -30px; opacity: 0.15; font-size: 8rem; color: #fff;">
                    <i class="fas fa-paw"></i>
                </div>

                <h5 class="font-weight-bold mb-1">Animalia Vet Clinic</h5>
                <p class="mb-3 small text-white-90 font-weight-bold" style="max-width: 70%; opacity: 0.9;">Professional Care
                    with Heart <i class="fas fa-heart text-warning ml-1"></i></p>

                @if(isset($unpaidTransactions) && $unpaidTransactions > 0)
                    <div
                        class="d-inline-block bg-white text-danger px-3 py-1 rounded-pill small font-weight-bold shadow-sm animate-float">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $unpaidTransactions }} Tagihan belum lunas
                    </div>
                @else
                    <button class="btn btn-sm btn-light text-danger rounded-pill font-weight-bold px-3 shadow-sm">
                        <i class="fas fa-shield-alt mr-1"></i> Status Member: Aktif
                    </button>
                @endif
            </div>
        </div>

        <!-- Active Booking -->
        <div class="section-title mb-3 animate-slide-up delay-1">
            <h6 class="font-weight-800 text-dark">Jadwal Hari Ini <span
                    class="badge badge-warning text-white ml-2 rounded-circle">1</span></h6>
        </div>

        @if($upcomingBooking)
            <div class="medical-file-card mb-4 animate-slide-up delay-1">
                <div class="file-tab">PRIORITY</div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-red-soft text-danger mr-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <span class="d-block small text-muted font-weight-bold">ANTREAN NO.</span>
                                <h3 class="font-weight-800 text-dark mb-0 line-height-1">{{ $upcomingBooking->no_antrean }}</h3>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-success px-3 py-1 rounded-pill shadow-sm">Confirmed</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label class="small text-muted font-weight-bold d-block mb-0">PASIEN</label>
                            <span class="font-weight-bold text-dark">{{ $upcomingBooking->hewan->nama_hewan }}</span>
                        </div>
                        <div class="col-6 text-right">
                            <label class="small text-muted font-weight-bold d-block mb-0">DOKTER</label>
                            <span class="font-weight-bold text-dark">Dr.
                                {{ $upcomingBooking->jadwalPraktek->dokter->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card mb-4 text-center py-4 border-dashed animate-slide-up delay-1">
                <i class="fas fa-couch text-muted mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                <p class="text-muted small mb-0">Tidak ada jadwal pemeriksaan hari ini.</p>
            </div>
        @endif

        <!-- My Pets -->
        <div class="d-flex justify-content-between align-items-center mb-3 animate-slide-up delay-2">
            <h6 class="font-weight-800 text-dark mb-0">Kartu Pasien</h6>
            <button class="btn btn-sm btn-danger-soft rounded-circle" style="width: 35px; height: 35px; padding: 0;"
                data-toggle="modal" data-target="#addHewanModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        @if($hewans->isEmpty())
            <div class="empty-state animate-slide-up delay-2 text-center py-3">
                <div class="bg-white rounded-circle d-inline-flex p-3 shadow-sm mb-2">
                    <i class="fas fa-paw fa-2x text-muted"></i>
                </div>
                <p class="text-muted small">Anda belum mendaftarkan hewan peliharaan.</p>
            </div>
        @else
            <div class="pet-scroll-container animate-slide-up delay-2">
                @foreach($hewans as $hewan)
                    <div class="pet-card mr-3">
                        <!-- Dynamic Color based on Pet Type -->
                        <div
                            class="pet-card-header {{ $hewan->jenis_hewan == 'Kucing' ? 'bg-gradient-gold' : ($hewan->jenis_hewan == 'Anjing' ? 'bg-gradient-red' : 'bg-gradient-dark') }}">
                            <i
                                class="fas {{ $hewan->jenis_hewan == 'Kucing' ? 'fa-cat' : ($hewan->jenis_hewan == 'Anjing' ? 'fa-dog' : 'fa-dove') }} text-white-50 icon-bg"></i>
                            <h5 class="text-white font-weight-bold mb-0">{{ $hewan->nama_hewan }}</h5>
                            <small class="text-white opacity-75">{{ $hewan->jenis_hewan }} &bull; {{ $hewan->ras ?? '-' }}</small>
                        </div>
                        <div class="pet-card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Usia</span>
                                <span class="small font-weight-bold text-dark">{{ $hewan->getUsia($hewan->tanggal_lahir) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small text-muted">Berat</span>
                                <span class="small font-weight-bold text-dark">{{ $hewan->berat_badan }} kg</span>
                            </div>
                            <button class="btn btn-block btn-outline-danger btn-sm mt-3 font-weight-bold rounded-pill border-2"
                                style="font-size: 0.7rem;">
                                RIWAYAT MEDIS
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Last Visit Record -->
        @if(isset($lastVisit) && $lastVisit)
            <div class="card mt-4 animate-slide-up delay-3">
                <div class="card-body p-3">
                    <div class="d-flex">
                        <div class="mr-3">
                            <div class="bg-gold-soft rounded-circle p-3 d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-file-medical-alt text-warning"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-1">Catatan Medis Terakhir</h6>
                            <p class="small text-muted mb-0">
                                {{ $lastVisit->booking->hewan->nama_hewan }} - <span
                                    class="text-dark font-weight-bold">{{ $lastVisit->diagnosa }}</span>
                            </p>
                            <small class="text-danger font-weight-bold"
                                style="font-size: 0.75rem;">{{ optional($lastVisit->tanggal_periksa)->format('d F Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Simple Modal -->
        <div class="modal fade" id="addHewanModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <h5 class="modal-title font-weight-bold">Pasien Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Reuse previous form logic but adjust styling -->
                    <form action="{{ route('pelanggan.hewan.store') }}" method="POST">
                        @csrf
                        <div class="modal-body px-4 pt-4">
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-muted">NAMA HEWAN</label>
                                <input type="text" class="form-control bg-light border-0 rounded-lg" name="nama_hewan"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="small font-weight-bold text-muted">JENIS</label>
                                <select class="form-control bg-light border-0 rounded-lg" name="jenis_hewan" required>
                                    <option value="Kucing">Kucing</option>
                                    <option value="Anjing">Anjing</option>
                                    <option value="Kelinci">Kelinci</option>
                                    <option value="Burung">Burung</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold text-muted">UMUR</label>
                                        <input type="number" class="form-control bg-light border-0 rounded-lg" name="umur">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold text-muted">BERAT</label>
                                        <input type="number" step="0.1" class="form-control bg-light border-0 rounded-lg"
                                            name="berat_badan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4">
                            <button type="submit" class="btn btn-primary btn-block rounded-pill">SIMPAN DATA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dashboard Specific Styles for Animalia Theme */
        .blob-bg {
            position: absolute;
            top: -80px;
            right: -80px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(230, 57, 70, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: -1;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #E63946, #B71C1C);
        }

        .bg-gradient-red {
            background: linear-gradient(135deg, #FF5252, #D32F2F);
        }

        .bg-gradient-gold {
            background: linear-gradient(135deg, #FFC107, #F57F17);
        }

        .bg-gradient-dark {
            background: linear-gradient(135deg, #455A64, #263238);
        }

        .bg-red-soft {
            background: rgba(230, 57, 70, 0.1);
        }

        .bg-gold-soft {
            background: rgba(255, 193, 7, 0.15);
        }

        .btn-danger-soft {
            background: rgba(230, 57, 70, 0.15);
            color: #E63946;
            border: none;
        }

        .btn-danger-soft:hover {
            background: #E63946;
            color: white;
        }

        .border-dashed {
            border: 2px dashed #e0e0e0;
            border-radius: 15px;
        }

        /* Medical File Card */
        .medical-file-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            border-left: 5px solid #E63946;
        }

        .file-tab {
            position: absolute;
            top: 0;
            right: 20px;
            background: #E63946;
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 5px 15px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Pet Cards */
        .pet-scroll-container {
            display: flex;
            overflow-x: auto;
            padding-bottom: 20px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .pet-scroll-container::-webkit-scrollbar {
            display: none;
        }

        .pet-card {
            min-width: 180px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .pet-card:hover {
            transform: translateY(-5px);
        }

        .pet-card-header {
            padding: 20px;
            position: relative;
        }

        .icon-bg {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 4rem;
            opacity: 0.2;
            transform: rotate(-20deg);
        }

        .pet-card-body {
            padding: 15px;
        }
    </style>
@endsection